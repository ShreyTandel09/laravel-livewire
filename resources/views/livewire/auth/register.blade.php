<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enhanced Client-Side Form Validation</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.3/cdn.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css"></script>
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

        .success-pulse {
            animation: pulse 2s infinite;
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
            <div class="text-center mb-6">
                <div class="inline-flex items-center justify-center w-14 h-14 bg-indigo-100 rounded-full mb-3">
                    <svg class="w-7 h-7 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                </div>
                <h1 class="text-2xl font-semibold text-gray-800">Create Account</h1>
                <p class="text-gray-500 text-sm mt-1">Join us and start your journey</p>
            </div>

            <!-- Registration Form -->
            <div class="bg-white shadow-md rounded-lg p-6 border border-gray-100" x-data="validateRegisterForm()">
                <form @submit.prevent="handleSubmit" :class="{ 'shake': formShake }" wire:submit="register">
                    <div class="space-y-5">
                        <!-- Name Field -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                                Full Name *
                                <span x-show="fields.name.isValid" class="text-green-500 ml-1">✓</span>
                            </label>
                            <input
                                id="name"
                                type="text"
                                wire:model="name"
                                x-model="fields.name.value"
                                @input="validateField('name')"
                                @blur="validateField('name')"
                                class="w-full px-4 py-2.5 border rounded-md focus:ring-1 focus:ring-indigo-400 focus:border-indigo-400 text-sm transition-all duration-200"
                                :class="{
                                    'field-valid': fields.name.isValid && fields.name.touched,
                                    'field-invalid': fields.name.error && fields.name.touched,
                                    'border-gray-300': !fields.name.touched
                                }"
                                placeholder="Enter your full name" />
                            <div x-show="fields.name.error && fields.name.touched" x-transition class="mt-1 text-xs text-red-600" x-text="fields.name.error"></div>
                        </div>

                        <!-- Company Field -->
                        <div>
                            <label for="company" class="block text-sm font-medium text-gray-700 mb-1">
                                Company Name *
                                <span x-show="fields.company.isValid" class="text-green-500 ml-1">✓</span>
                            </label>
                            <input
                                id="company"
                                type="text"
                                wire:model="company"
                                x-model="fields.company.value"
                                @input="validateField('company')"
                                @blur="validateField('company')"
                                class="w-full px-4 py-2.5 border rounded-md focus:ring-1 focus:ring-indigo-400 focus:border-indigo-400 text-sm transition-all duration-200"
                                :class="{
                                    'field-valid': fields.company.isValid && fields.company.touched,
                                    'field-invalid': fields.company.error && fields.company.touched,
                                    'border-gray-300': !fields.company.touched
                                }"
                                placeholder="Enter your company name" />
                            <div x-show="fields.company.error && fields.company.touched" x-transition class="mt-1 text-xs text-red-600" x-text="fields.company.error"></div>
                        </div>

                        <!-- Email Field -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                                Email Address *
                                <span x-show="fields.email.isValid" class="text-green-500 ml-1">✓</span>
                            </label>
                            <input
                                id="email"
                                type="email"
                                wire:model="email"
                                x-model="fields.email.value"
                                @input="validateField('email')"
                                @blur="validateField('email')"
                                class="w-full px-4 py-2.5 border rounded-md focus:ring-1 focus:ring-indigo-400 focus:border-indigo-400 text-sm transition-all duration-200"
                                :class="{
                                    'field-valid': fields.email.isValid && fields.email.touched,
                                    'field-invalid': fields.email.error && fields.email.touched,
                                    'border-gray-300': !fields.email.touched
                                }"
                                placeholder="Enter your email address" />
                            <div x-show="fields.email.error && fields.email.touched" x-transition class="mt-1 text-xs text-red-600" x-text="fields.email.error"></div>
                        </div>

                        <!-- Password Field -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                                Password *
                                <span x-show="fields.password.isValid" class="text-green-500 ml-1">✓</span>
                            </label>
                            <div class="relative">
                                <input
                                    id="password"
                                    :type="showPassword ? 'text' : 'password'"
                                    x-model="fields.password.value"
                                    wire:model="password"

                                    @input="validateField('password'); validateField('confirmPassword')"
                                    @blur="validateField('password')"
                                    class="w-full px-4 py-2.5 pr-10 border rounded-md focus:ring-1 focus:ring-indigo-400 focus:border-indigo-400 text-sm transition-all duration-200"
                                    :class="{
                                        'field-valid': fields.password.isValid && fields.password.touched,
                                        'field-invalid': fields.password.error && fields.password.touched,
                                        'border-gray-300': !fields.password.touched
                                    }"
                                    placeholder="Create a strong password" />
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
                            <div x-show="fields.password.error && fields.password.touched" x-transition class="mt-1 text-xs text-red-600" x-text="fields.password.error"></div>
                            <!-- Password Strength Indicator -->
                            <div x-show="fields.password.value.length > 0" x-transition class="mt-2">
                                <div class="flex space-x-1">
                                    <div class="h-1 flex-1 rounded" :class="passwordStrength >= 1 ? 'bg-red-500' : 'bg-gray-200'"></div>
                                    <div class="h-1 flex-1 rounded" :class="passwordStrength >= 2 ? 'bg-yellow-500' : 'bg-gray-200'"></div>
                                    <div class="h-1 flex-1 rounded" :class="passwordStrength >= 3 ? 'bg-green-500' : 'bg-gray-200'"></div>
                                </div>
                                <p class="text-xs mt-1" :class="{
                                    'text-red-600': passwordStrength === 1,
                                    'text-yellow-600': passwordStrength === 2,
                                    'text-green-600': passwordStrength === 3
                                }" x-text="passwordStrengthText"></p>
                            </div>
                        </div>

                        <!-- Confirm Password Field -->
                        <div>
                            <label for="confirmPassword" class="block text-sm font-medium text-gray-700 mb-1">
                                Confirm Password *
                                <span x-show="fields.confirmPassword.isValid" class="text-green-500 ml-1">✓</span>
                            </label>
                            <input
                                id="confirmPassword"
                                type="password"
                                x-model="fields.confirmPassword.value"
                                wire:model="confirmPassword"
                                @input="validateField('confirmPassword')"
                                @blur="validateField('confirmPassword')"
                                class="w-full px-4 py-2.5 border rounded-md focus:ring-1 focus:ring-indigo-400 focus:border-indigo-400 text-sm transition-all duration-200"
                                :class="{
                                    'field-valid': fields.confirmPassword.isValid && fields.confirmPassword.touched,
                                    'field-invalid': fields.confirmPassword.error && fields.confirmPassword.touched,
                                    'border-gray-300': !fields.confirmPassword.touched
                                }"
                                placeholder="Confirm your password" />
                            <div x-show="fields.confirmPassword.error && fields.confirmPassword.touched" x-transition class="mt-1 text-xs text-red-600" x-text="fields.confirmPassword.error"></div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="mt-6">
                        <button
                            type="submit"
                            :disabled="!isFormValid || isSubmitting"
                            class="w-full py-2.5 px-4 rounded-md text-sm font-medium transition-all duration-200 focus:ring-2 focus:ring-indigo-400 focus:ring-offset-1"
                            :class="isFormValid && !isSubmitting ? 
                                'bg-indigo-500 hover:bg-indigo-600 text-white' : 
                                'bg-gray-300 text-gray-500 cursor-not-allowed'">
                            <span x-show="!isSubmitting">Create Account</span>
                            <span x-show="isSubmitting" class="flex items-center justify-center">
                                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Creating Account...
                            </span>
                        </button>
                    </div>

                    <div class="mt-6 text-center">
                        <p class="text-gray-500 text-sm">
                            Already have an account?
                            <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-800 font-medium">Login</a>
                        </p>
                    </div>
                </form>

                <!-- Success Message -->
                <div x-show="showSuccess" x-transition class="mt-4 bg-green-50 border border-green-200 rounded-md p-3 text-sm text-green-700">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        Account created successfully! Welcome aboard!
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function validateRegisterForm() {
            return {
                fields: {
                    name: {
                        value: '',
                        error: '',
                        isValid: false,
                        touched: false
                    },
                    company: {
                        value: '',
                        error: '',
                        isValid: false,
                        touched: false
                    },
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
                    confirmPassword: {
                        value: '',
                        error: '',
                        isValid: false,
                        touched: false
                    }
                },
                isSubmitting: false,
                showSuccess: false,
                formShake: false,
                showPassword: false,

                get isFormValid() {
                    return Object.values(this.fields).every(field => field.isValid);
                },

                get passwordStrength() {
                    const password = this.fields.password.value;
                    let strength = 0;

                    if (password.length >= 8) strength++;
                    if (/[A-Z]/.test(password) && /[a-z]/.test(password)) strength++;
                    if (/\d/.test(password) && /[!@#$%^&*(),.?":{}|<>]/.test(password)) strength++;

                    return strength;
                },

                get passwordStrengthText() {
                    switch (this.passwordStrength) {
                        case 1:
                            return 'Weak';
                        case 2:
                            return 'Medium';
                        case 3:
                            return 'Strong';
                        default:
                            return 'Very Weak';
                    }
                },

                validateField(fieldName) {
                    const field = this.fields[fieldName];
                    field.touched = true;
                    field.error = '';
                    field.isValid = false;

                    switch (fieldName) {
                        case 'name':
                            if (!field.value.trim()) {
                                field.error = 'Full name is required';
                            } else if (field.value.trim().length < 2) {
                                field.error = 'Name must be at least 2 characters';
                            } else if (!/^[a-zA-Z\s]+$/.test(field.value.trim())) {
                                field.error = 'Name can only contain letters and spaces';
                            } else {
                                field.isValid = true;
                            }
                            break;

                        case 'company':
                            if (!field.value.trim()) {
                                field.error = 'Company name is required';
                            } else if (field.value.trim().length < 2) {
                                field.error = 'Company name must be at least 2 characters';
                            } else {
                                field.isValid = true;
                            }
                            break;

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
                            } else if (field.value.length < 8) {
                                field.error = 'Password must be at least 8 characters';
                            } else if (!/(?=.*[a-z])(?=.*[A-Z])/.test(field.value)) {
                                field.error = 'Password must contain both uppercase and lowercase letters';
                            } else if (!/(?=.*\d)/.test(field.value)) {
                                field.error = 'Password must contain at least one number';
                            } else {
                                field.isValid = true;
                            }
                            break;

                        case 'confirmPassword':
                            if (!field.value) {
                                field.error = 'Please confirm your password';
                            } else if (field.value !== this.fields.password.value) {
                                field.error = 'Passwords do not match';
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

                    // this.$wire.dispatch('register');


                    // For Laravel Livewire integration, use one of these methods:

                    // Method 1: Direct Livewire call (if using @this)
                    // @this.call('register');

                    // Method 2: Dispatch Livewire event
                    // @this.dispatch('register-user', {
                    //     name: this.fields.name.value,
                    //     email: this.fields.email.value,
                    //     company: this.fields.company.value,
                    //     password: this.fields.password.value
                    // });

                    // Method 3: Submit the actual form (remove @submit.prevent and let form submit normally)
                    // document.getElementById('Register').submit();

                    setTimeout(() => {
                        this.isSubmitting = false;
                        this.showSuccess = true;

                        // Reset form after success
                        setTimeout(() => {
                            this.resetForm();
                        }, 2000);
                    }, 2000);
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
                }
            };
        }
    </script>
</body>

</html>