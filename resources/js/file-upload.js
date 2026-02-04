import axios from 'axios';
import Swal from 'sweetalert2';

export class FileUploadHandler {
    constructor(formSelector, progressBarSelector = null, options = {}) {
        this.form = document.querySelector(formSelector);
        this.progressBar = progressBarSelector ? document.querySelector(progressBarSelector) : null;
        this.submitBtn = this.form ? this.form.querySelector('button[type="submit"]') : null;
        this.options = options;

        if (this.form) {
            this.init();
        }
    }

    init() {
        this.form.addEventListener('submit', (e) => {
            e.preventDefault();
            this.submitForm();
        });
    }

    async submitForm() {
        const formData = new FormData(this.form);

        // Reset validation states
        this.clearErrors();
        this.setLoading(true);

        try {
            const response = await axios.post(this.form.action, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                onUploadProgress: (progressEvent) => {
                    if (this.progressBar && progressEvent.total) {
                        const percentCompleted = Math.round((progressEvent.loaded * 100) / progressEvent.total);
                        this.updateProgressBar(percentCompleted);
                    }
                }
            });

            // Handle success
            if (response.data.redirect || response.request.responseURL) {
                // If the server redirects, we can follow it
                const targetUrl = response.data.redirect || response.request.responseURL;

                // If Axios followed the redirect automatically (which it does not do for clean redirects often in AJAX) 
                // or if we returned JSON with a redirect URL.

                // Check if the response URL is different from the request action (implies redirect happened)
                if (response.request.responseURL && response.request.responseURL !== this.form.action) {
                    window.location.href = response.request.responseURL;
                    return;
                }

                // Fallback: If we just got HTML back (the redirect page), we might need to manually reload or redirect
                // Ideally, controllers should return JSON for AJAX.
                // But if they return a redirect, Axios receives the CONTENT of the redirected page with status 200.

                // Let's assume on success, we show a success message and then redirect if needed.
                // For now, let's just reload or go to index if we can infer it.
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Operation completed successfully.',
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    // Try to find a redirect URL from response or just go back
                    // Ideally modify controller to return JSON.
                    // But if not, we can force a reload or specific redirect.
                    // Let's rely on options.redirectUrl if provided, otherwise reload
                    if (this.options.redirectUrl) {
                        window.location.href = this.options.redirectUrl;
                    } else {
                        window.location.href = window.location.href; // Reload
                    }
                });
            }

        } catch (error) {
            this.setLoading(false);
            if (this.progressBar) this.updateProgressBar(0, true);

            if (error.response && error.response.status === 422) {
                this.displayErrors(error.response.data.errors);
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    text: 'Please checks the fields and try again.'
                });
            } else {
                console.error(error);
                Swal.fire({
                    icon: 'error',
                    title: 'Upload Failed',
                    text: error.response?.data?.message || 'An error occurred during upload.'
                });
            }
        }
    }

    setLoading(loading) {
        if (this.submitBtn) {
            this.submitBtn.disabled = loading;
            const originalText = this.submitBtn.getAttribute('data-original-text') || this.submitBtn.innerText;

            if (loading) {
                this.submitBtn.setAttribute('data-original-text', originalText);
                this.submitBtn.innerHTML = `<span class="spinner-border spinner-border-sm me-2"></span>Processing...`;
            } else {
                this.submitBtn.innerHTML = originalText;
            }
        }

        if (loading && this.progressBar) {
            this.progressBar.closest('.progress-container').classList.remove('d-none');
        }
    }

    updateProgressBar(percent, error = false) {
        if (!this.progressBar) return;

        this.progressBar.style.width = `${percent}%`;
        this.progressBar.innerText = `${percent}%`;
        this.progressBar.classList.toggle('bg-danger', error);
        this.progressBar.classList.toggle('bg-success', !error && percent === 100);
    }

    clearErrors() {
        this.form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        this.form.querySelectorAll('.invalid-feedback').forEach(el => el.remove());
    }

    displayErrors(errors) {
        for (const [field, messages] of Object.entries(errors)) {
            // Handle array fields specifically for this app (documents.0, images.0 etc)
            let selector = `[name="${field}"]`;

            if (field.includes('.')) {
                const [base, index] = field.split('.');
                // Try to match array inputs like images[], documents[]
                // This is tricky without predictable DOM order, but we can try targeting by index
                const inputs = this.form.querySelectorAll(`[name="${base}[]"]`);
                if (inputs[index]) {
                    this.showError(inputs[index], messages[0]);
                    continue;
                }
            }

            const input = this.form.querySelector(selector);
            if (input) {
                this.showError(input, messages[0]);
            }
        }
    }

    showError(input, message) {
        input.classList.add('is-invalid');
        const feedback = document.createElement('div');
        feedback.className = 'invalid-feedback';
        feedback.innerText = message;
        input.parentNode.appendChild(feedback);
    }
}
