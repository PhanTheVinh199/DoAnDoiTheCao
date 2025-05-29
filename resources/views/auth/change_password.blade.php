@include('partials.header')

<div class="container">
    <h3>Đổi mật khẩu</h3>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('password.change') }}" method="POST">
        @csrf

        <div class="form-group">
            <label>Mật khẩu hiện tại</label>
            <div class="input-group">
                <input type="password" name="current_password" id="current_password" class="form-control" required minlength="6" maxlength="30">
                <button type="button" class="btn btn-outline-secondary toggle-password" data-target="current_password">
                    <i class="fa-solid fa-eye-slash"></i>
                </button>
            </div>
            @error('current_password') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-group mt-3">
            <label>Mật khẩu mới</label>
            <div class="input-group">
                <input type="password" name="new_password" id="new_password" class="form-control" required minlength="6" maxlength="30">
                <button type="button" class="btn btn-outline-secondary toggle-password" data-target="new_password">
                    <i class="fa-solid fa-eye-slash"></i>
                </button>
            </div>
            @error('new_password') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-group mt-3">
            <label>Nhập lại mật khẩu mới</label>
            <div class="input-group">
                <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control" required minlength="6" maxlength="30">
                <button type="button" class="btn btn-outline-secondary toggle-password" data-target="new_password_confirmation">
                    <i class="fa-solid fa-eye-slash"></i>
                </button>
            </div>
        </div>

        <button type="submit" class="btn btn-success mt-3">Đổi mật khẩu</button>
    </form>
</div>

<script>
    document.querySelectorAll('.toggle-password').forEach(button => {
        button.addEventListener('click', function () {
            const targetId = this.getAttribute('data-target');
            const input = document.getElementById(targetId);
            const icon = this.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            }
        });
    });
</script>

@include('partials.footer')
