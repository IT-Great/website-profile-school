<script setup>
import { ref } from 'vue'
import { Link, useForm } from '@inertiajs/vue3'
import { Eye, EyeOff } from 'lucide-vue-next'

const showPassword = ref(false)

const form = useForm({
    name: '',
    password: '',
})

const submit = () => {
    form.post(route('login-admin'), {
        onFinish: () => form.reset('password'),
    })
}
</script>

<template>

<div class="login-page">

    <div class="bg-decoration"></div>

    <div id="auth">

        <div class="auth-container">

            <div class="auth-logo">

                <h4>Web Profile Great Crystal School</h4>

            </div>

            <form @submit.prevent="submit">

                <!-- Username -->

                <div class="form-group">

                    <label for="name">Username</label>

                    <input
                        id="name"
                        v-model="form.name"
                        type="text"
                        class="form-control"
                        :class="{ 'is-invalid': form.errors.name }"
                        placeholder="Masukkan username Anda"
                        required
                        autofocus
                    >

                    <div v-if="form.errors.name" class="invalid-feedback">

                        {{ form.errors.name }}

                    </div>

                </div>

                <!-- Password -->

                <div class="form-group">

                    <label for="password">Password</label>

                    <div class="password-container">

                        <input
                            id="password"
                            v-model="form.password"
                            :type="showPassword ? 'text' : 'password'"
                            class="form-control"
                            :class="{ 'is-invalid': form.errors.password }"
                            placeholder="Masukkan password Anda"
                            required
                        >

                        <component
                            :is="showPassword ? EyeOff : Eye"
                            class="password-toggle-icon"
                            @click="showPassword = !showPassword"
                        />

                    </div>

                    <div v-if="form.errors.password" class="invalid-feedback">

                        {{ form.errors.password }}

                    </div>

                </div>

                <button
                    type="submit"
                    class="btn-primary"
                    :class="{ loading: form.processing }"
                    :disabled="form.processing">

                    <span>{{ form.processing ? 'Memproses...' : 'Masuk ke Dashboard' }}</span>

                </button>

            </form>

        </div>

    </div>

</div>

</template>

<style scoped>
.login-page {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: url('/storage/images/hero/hero1.png') no-repeat center center;
    background-size: cover;
    background-attachment: fixed;
    min-height: 100vh;
    position: relative;
    overflow-x: hidden;
}

.bg-decoration {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: -1;
    overflow: hidden;
    background: rgba(0, 0, 0, 0.1);
}

.bg-decoration::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 70%);
    animation: float 20s ease-in-out infinite;
}

.bg-decoration::after {
    content: '';
    position: absolute;
    bottom: -50%;
    right: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.03) 0%, transparent 70%);
    animation: float 25s ease-in-out infinite reverse;
}

@keyframes float {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    50% { transform: translateY(-20px) rotate(180deg); }
}

#auth {
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 2rem;
    position: relative;
}

.auth-container {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(15px);
    border: 1px solid rgba(255, 255, 255, 0.3);
    max-width: 450px;
    width: 100%;
    padding: 3rem;
    border-radius: 20px;
    box-shadow:
        0 20px 40px rgba(0, 0, 0, 0.15),
        0 8px 32px rgba(0, 0, 0, 0.1),
        0 0 0 1px rgba(255, 255, 255, 0.4);
    transition: all 0.3s ease;
}

.auth-container:hover {
    transform: translateY(-5px);
    box-shadow:
        0 25px 50px rgba(0, 0, 0, 0.2),
        0 12px 40px rgba(0, 0, 0, 0.15),
        0 0 0 1px rgba(255, 255, 255, 0.5);
}

.auth-logo {
    text-align: center;
    margin-bottom: 2rem;
}

.auth-logo h4 {
    font-size: 2.2rem;
    font-weight: 700;
    background: linear-gradient(135deg, #183018 0%, #2d4f2d 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 0.5rem;
}

.auth-title {
    font-size: 2.2rem;
    font-weight: 600;
    margin-bottom: 1rem;
    text-align: center;
    color: #2d3748;
}

.auth-subtitle {
    font-size: 1rem;
    line-height: 1.6;
    color: #718096;
    text-align: center;
    margin-bottom: 2.5rem;
}

.form-group {
    position: relative;
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 600;
    color: #4a5568;
    font-size: 0.9rem;
}

.form-control {
    width: 100%;
    padding: 1rem 1.2rem;
    font-size: 1rem;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    background: rgba(255, 255, 255, 0.9);
    transition: all 0.3s ease;
    outline: none;
}

.form-control:focus {
    border-color: #183018;
    box-shadow: 0 0 0 3px rgba(24, 48, 24, 0.1);
    background: rgba(255, 255, 255, 1);
}

.form-control.is-invalid {
    border-color: #e53e3e;
}

.password-container {
    position: relative;
}

.password-toggle-icon {
    position: absolute;
    top: 50%;
    right: 15px;
    transform: translateY(-50%);
    width: 20px;
    height: 20px;
    cursor: pointer;
    color: #a0aec0;
    transition: color 0.3s ease;
}

.password-toggle-icon:hover {
    color: #183018;
}

.btn-primary {
    position: relative;
    width: 100%;
    padding: 1rem;
    font-size: 1.1rem;
    font-weight: 600;
    background: linear-gradient(135deg, #183018 0%, #2d4f2d 100%);
    border: none;
    border-radius: 12px;
    color: white;
    transition: all 0.3s ease;
    margin-top: 1rem;
    cursor: pointer;
}

.btn-primary:hover:not(:disabled) {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(24, 48, 24, 0.3);
    background: linear-gradient(135deg, #1a3a1a 0%, #2a4a2a 100%);
}

.btn-primary:active:not(:disabled) {
    transform: translateY(0);
}

.btn-primary:disabled {
    cursor: not-allowed;
}

.btn-primary.loading {
    pointer-events: none;
    opacity: 0.7;
}

.btn-primary.loading::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 20px;
    height: 20px;
    margin-top: -10px;
    margin-left: -10px;
    border: 2px solid transparent;
    border-top: 2px solid #ffffff;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.forgot-password {
    text-align: center;
    margin-top: 2rem;
}

.forgot-password a {
    color: #183018;
    text-decoration: none;
    font-weight: 600;
    transition: color 0.3s ease;
}

.forgot-password a:hover {
    color: #1a3a1a;
    text-decoration: underline;
}

.invalid-feedback {
    display: block;
    color: #e53e3e;
    font-size: 0.875rem;
    margin-top: 0.5rem;
}

@media (max-width: 768px) {
    #auth {
        padding: 1rem;
    }

    .auth-container {
        padding: 2rem;
        margin: 1rem;
    }

    .auth-logo h4 {
        font-size: 1.8rem;
    }

    .auth-title {
        font-size: 1.8rem;
    }
}
</style>