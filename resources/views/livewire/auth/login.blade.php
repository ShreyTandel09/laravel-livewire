<!DOCTYPE html>
<html lang="en">

<head>

    <style>
        @import url('https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css');

        .shake {
            animation: shake 0.5s ease-in-out;
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-5px);
            }

            75% {
                transform: translateX(5px);
            }
        }

        .field-valid {
            border-color: #10b981 !important;
            background-color: #ecfdf5;
        }

        .field-invalid {
            border-color: #ef4444 !important;
            background-color: #fef2f2;
        }
    </style>
</head>





<body>

    <div class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-cyan-50 flex items-center justify-center p-4">

        @include('components.ui.toast')
        <div class="w-full max-w-md">

            <!-- Header -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-indigo-500 rounded-full mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-900">Login</h1>
                <p class="text-gray-500 mt-2">Welcome back! Please sign in to your account</p>
            </div>

            <!-- Login Form -->
            <div class="bg-white shadow-md rounded-xl p-8" x-data="validateLoginForm()">
                <form @submit.prevent="handleSubmit" :class="{ 'shake': formShake }" wire:submit="login">

                    <div class="space-y-6">

                        <!-- Email Field -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email Address <span class="text-red-500">*</span>
                                <span x-show="fields.email.isValid" class="text-green-500 ml-1">✓</span>
                            </label>
                            <input
                                type="email"
                                id="email"
                                wire:model="email"
                                x-model="fields.email.value"
                                @input="validateField('email')"
                                @blur="validateField('email')"
                                class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition-all duration-200"
                                :class="{
                                    'field-valid': fields.email.isValid && fields.email.touched,
                                    'field-invalid': fields.email.error && fields.email.touched,
                                    'border-gray-300': !fields.email.touched
                                }"
                                placeholder="Enter your email address" />
                            <div x-show="fields.email.error && fields.email.touched" x-transition class="mt-1 text-sm text-red-600" x-text="fields.email.error"></div>
                        </div>

                        <!-- Password Field -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                Password <span class="text-red-500">*</span>
                                <span x-show="fields.password.isValid" class="text-green-500 ml-1">✓</span>
                            </label>
                            <div class="relative">
                                <input
                                    :type="showPassword ? 'text' : 'password'"
                                    id="password"
                                    wire:model="password"
                                    x-model="fields.password.value"
                                    @input="validateField('password')"
                                    @blur="validateField('password')"
                                    class="w-full px-4 py-3 pr-10 border rounded-lg focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition-all duration-200"
                                    :class="{
                                        'field-valid': fields.password.isValid && fields.password.touched,
                                        'field-invalid': fields.password.error && fields.password.touched,
                                        'border-gray-300': !fields.password.touched
                                    }"
                                    placeholder="Enter your password" />
                                <button
                                    type="button"
                                    @click="showPassword = !showPassword"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                                    <svg x-show="!showPassword" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    <svg x-show="showPassword" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                                    </svg>
                                </button>
                            </div>
                            <div x-show="fields.password.error && fields.password.touched" x-transition class="mt-1 text-sm text-red-600" x-text="fields.password.error"></div>
                        </div>

                        <!-- Remember Me -->
                        <!-- <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <input
                                    id="remember"
                                    type="checkbox"
                                    x-model="rememberMe"
                                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" />
                                <label for="remember" class="ml-2 block text-sm text-gray-700">
                                    Remember me
                                </label>
                            </div>
                            <a href="#" class="text-sm text-indigo-600 hover:text-indigo-500">
                                Forgot password?
                            </a>
                        </div> -->

                    </div>

                    <!-- Submit Button -->
                    <div class="mt-8">
                        <button
                            type="submit"
                            :disabled="!isFormValid || isSubmitting"
                            class="w-full py-3 px-4 rounded-lg font-medium transition-all duration-200 focus:ring-2 focus:ring-indigo-400 focus:ring-offset-2"
                            :class="isFormValid && !isSubmitting ? 
                                'bg-indigo-500 hover:bg-indigo-600 text-white' : 
                                'bg-gray-300 text-gray-500 cursor-not-allowed'">
                            <span x-show="!isSubmitting">Login</span>
                            <span x-show="isSubmitting" class="flex items-center justify-center">
                                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Signing in...
                            </span>
                        </button>
                    </div>

                </form>

                <!-- Register Link -->
                <div class="mt-6 text-center">
                    <p class="text-gray-500 text-sm">
                        Don't have an account?
                        <a href="{{ route('register') }}" class="text-indigo-600 hover:text-indigo-800 font-medium">Register</a>
                    </p>
                </div>

                <!-- Success Message -->
                <!-- <div x-show="showSuccess" x-transition class="mt-4 bg-green-50 border border-green-200 rounded-md p-3 text-sm text-green-700">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        Login successful! Redirecting...
                    </div>
                </div> -->

                <!-- Error Message -->
                <!-- <div x-show="showError" x-transition class="mt-4 bg-red-50 border border-red-200 rounded-md p-3 text-sm text-red-700">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                        </svg>
                        <span x-text="errorMessage"></span>
                    </div>
                </div> -->
            </div>

        </div>
    </div>

    <script>
        function validateLoginForm() {
            return {
                fields: {
                    email: {
                        value: '',
                        error: '',
                        isValid: false,
                        touched: false
                    },
                    password: {
                        value: '',
                        error: '',
                        isValid: false,
                        touched: false
                    },
                },
                formShake: false,
                isSubmitting: false,
                showSuccess: false,
                showError: false,
                errorMessage: '',
                rememberMe: false,
                showPassword: false,

                get isFormValid() {
                    return Object.values(this.fields).every(field => field.isValid);
                },

                validateField(fieldName) {
                    const field = this.fields[fieldName];
                    field.touched = true;
                    field.error = '';
                    field.isValid = false;

                    switch (fieldName) {
                        case 'email':
                            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                            if (!field.value.trim()) {
                                field.error = 'Email address is required';
                            } else if (!emailRegex.test(field.value.trim())) {
                                field.error = 'Please enter a valid email address';
                            } else {
                                field.isValid = true;
                            }
                            break;

                        case 'password':
                            if (!field.value) {
                                field.error = 'Password is required';
                            } else if (field.value.length < 3) { // Relaxed for login
                                field.error = 'Password is too short';
                            } else {
                                field.isValid = true;
                            }
                            break;
                    }
                },

                validateAllFields() {
                    Object.keys(this.fields).forEach(fieldName => {
                        this.validateField(fieldName);
                    });
                },

                handleSubmit() {
                    this.validateAllFields();

                    if (!this.isFormValid) {
                        this.triggerFormShake();
                        return;
                    }

                    this.isSubmitting = true;
                    this.showError = false;

                    // For Livewire integration, replace this setTimeout with:
                    // @this.call('login');

                    // Simulate login request
                    setTimeout(() => {
                        this.isSubmitting = false;

                        // Simulate random success/failure for demo
                        if (Math.random() > 0.3) {
                            this.showSuccess = true;
                            setTimeout(() => {
                                // Redirect or refresh page
                                window.location.href = '/dashboard';
                            }, 1500);
                        } else {
                            this.showError = true;
                            this.errorMessage = 'Invalid email or password. Please try again.';
                            setTimeout(() => {
                                this.showError = false;
                            }, 5000);
                        }
                    }, 1500);
                },

                triggerFormShake() {
                    this.formShake = true;
                    setTimeout(() => {
                        this.formShake = false;
                    }, 500);
                },

                resetForm() {
                    Object.keys(this.fields).forEach(key => {
                        this.fields[key] = {
                            value: '',
                            error: '',
                            isValid: false,
                            touched: false
                        };
                    });
                    this.showSuccess = false;
                    this.showError = false;
                    this.rememberMe = false;
                }
            };
        }
    </script>
</body>

</html>