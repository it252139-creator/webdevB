function validateForm(event) {
    const email = document.getElementById('email').value;
    const emailConfirm = document.getElementById('email_confirm').value;
    const password = document.getElementById('password').value;
    const passwordConfirm = document.getElementById('password_confirm').value;

    if (
        email === '' ||
        emailConfirm === '' ||
        password === '' ||
        passwordConfirm === ''
    ) {
        alert('必須項目をすべて入力してください。');
        event.preventDefault();
        return false;
    }

    if (email !== emailConfirm) {
        alert('メールアドレスが一致しません。');
        event.preventDefault();
        return false;
    }

    if (password !== passwordConfirm) {
        alert('パスワードが一致しません。');
        event.preventDefault();
        return false;
    }

    return true;
}

window.addEventListener('DOMContentLoaded', function () {
    document
        .getElementById('registration-form')
        .addEventListener('submit', validateForm);
});
