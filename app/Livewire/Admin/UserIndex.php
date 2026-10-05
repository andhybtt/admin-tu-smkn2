<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Manajemen Pengguna')]
class UserIndex extends Component
{
    use WithPagination;

    public const ROLES = [
        'admin'          => 'Admin',
        'kepala_sekolah' => 'Kepala Sekolah',
        'kepala_tu'      => 'Ka. TU',
        'kurikulum'      => 'Kurikulum',
        'petugas'        => 'TU / Petugas',
        'subyek'         => 'Siswa',
    ];

    public string $search = '';
    public string $roleFilter = '';

    public bool $showForm = false;
    public ?int $editingId = null;

    public string $name = '';
    public string $username = '';
    public string $email = '';
    public string $role = 'petugas';
    public string $password = '';

    public function mount(): void
    {
        abort_unless(auth()->user()?->role === 'admin', 403, 'Hanya admin yang dapat mengakses halaman ini.');
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingRoleFilter(): void
    {
        $this->resetPage();
    }

    public function create(): void
    {
        $this->resetForm();
        $this->showForm = true;
    }

    public function edit(int $id): void
    {
        $user = User::findOrFail($id);

        $this->resetForm();
        $this->editingId = $user->id;
        $this->name = $user->name;
        $this->username = (string) $user->username;
        $this->email = $user->email;
        $this->role = $user->role;
        $this->showForm = true;
    }

    public function closeForm(): void
    {
        $this->showForm = false;
        $this->resetForm();
    }

    public function generatePassword(): void
    {
        $this->password = Str::password(10, symbols: false);
    }

    public function save(): void
    {
        $isEdit = $this->editingId !== null;

        $data = $this->validate([
            'name'     => ['required', 'string', 'max:100'],
            'username' => ['required', 'string', 'max:50', Rule::unique('users', 'username')->ignore($this->editingId)],
            'email'    => ['required', 'email', 'max:150', Rule::unique('users', 'email')->ignore($this->editingId)],
            'role'     => ['required', Rule::in(array_keys(self::ROLES))],
            'password' => [$isEdit ? 'nullable' : 'required', 'string', 'min:6', 'max:100'],
        ], [], [
            'name' => 'nama', 'username' => 'username', 'email' => 'email', 'role' => 'peran', 'password' => 'kata sandi',
        ]);

        if ($isEdit) {
            $user = User::findOrFail($this->editingId);

            // Cegah admin mencabut hak akses dirinya sendiri
            if ($user->id === auth()->id() && $data['role'] !== 'admin') {
                $this->addError('role', 'Anda tidak dapat mengubah peran akun Anda sendiri.');
                return;
            }

            if ($data['password'] === '') {
                unset($data['password']);
            }

            $user->update($data);
            session()->flash('success', "Data pengguna {$user->name} berhasil diperbarui.");
        } else {
            $user = User::create($data);
            session()->flash('success', "Pengguna {$user->name} berhasil ditambahkan.");
        }

        $this->closeForm();
    }

    public function delete(int $id): void
    {
        if ($id === auth()->id()) {
            session()->flash('error', 'Anda tidak dapat menghapus akun yang sedang digunakan.');
            return;
        }

        $user = User::findOrFail($id);
        $name = $user->name;
        $user->delete();

        session()->flash('success', "Pengguna {$name} berhasil dihapus.");
    }

    private function resetForm(): void
    {
        $this->reset(['editingId', 'name', 'username', 'email', 'password']);
        $this->role = 'petugas';
        $this->resetValidation();
    }

    public function render()
    {
        $users = User::query()
            ->when($this->search !== '', function ($q) {
                $term = '%' . strtolower($this->search) . '%';
                $q->where(function ($q) use ($term) {
                    $q->whereRaw('LOWER(name) LIKE ?', [$term])
                        ->orWhereRaw('LOWER(username) LIKE ?', [$term])
                        ->orWhereRaw('LOWER(email) LIKE ?', [$term]);
                });
            })
            ->when($this->roleFilter !== '', fn ($q) => $q->where('role', $this->roleFilter))
            ->orderByRaw("CASE role WHEN 'admin' THEN 0 WHEN 'kepala_sekolah' THEN 1 WHEN 'kepala_tu' THEN 2 WHEN 'kurikulum' THEN 3 WHEN 'petugas' THEN 4 ELSE 5 END")
            ->orderBy('name')
            ->paginate(10);

        $counts = User::selectRaw('role, COUNT(*) as total')->groupBy('role')->pluck('total', 'role');

        return view('livewire.admin.user-index', [
            'users'  => $users,
            'counts' => $counts,
            'roles'  => self::ROLES,
        ]);
    }
}
