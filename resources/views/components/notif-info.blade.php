<div x-data="{ show: true }">
    <template x-if="show">
        <div class="border border-info-subtle rounded-3 px-3 py-2 mb-2 shadow-sm">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <div class="d-flex align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-info-circle-fill me-2 text-info" viewBox="0 0 16 16">
                        <path
                            d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2" />
                    </svg>
                    <p class="mb-0 fw-semibold text-dark">{{ $text }}</p>
                </div>
                <p class="mb-0 text-muted small">
                    {{ $time }}
                </p>
            </div>
            <div class="d-flex gap-2">
                <div x-data="{ markShow: true, isLoading: false }" x-init="
                window.addEventListener('markSuccess', function(e) {
                    if (e.detail.id === '{{ $id }}') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Notification marked as read!',
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true,
                        });
                        markShow = false;
                        isLoading = false;
                        show = false;
                    }
                });
                window.addEventListener('markError', function(e) {
                    if (e.detail.id === '{{ $id }}') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error in marking notification!',
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true,
                        });
                        isLoading = false;
                    }
                });">
                    <button x-show="markShow" type="button"
                        x-on:click="isLoading = true; $wire.mark('{{ $id }}');"
                        x-transition.duration.400ms :disabled="isLoading"
                        class="btn btn-outline-primary btn-sm icon-link rounded-3">
                        <span x-show="isLoading" style="display: none;"
                            class="spinner-border spinner-border-sm text-primary" role="status"
                            aria-hidden="true"></span>
                        <span x-show="!isLoading">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                fill="currentColor" class="bi bi-check2-all" viewBox="0 0 16 16">
                                <path
                                    d="M12.354 4.354a.5.5 0 0 0-.708-.708L5 10.293 1.854 7.146a.5.5 0 1 0-.708.708l3.5 3.5a.5.5 0 0 0 .708 0zm-4.208 7-.896-.897.707-.707.543.543 6.646-6.647a.5.5 0 0 1 .708.708l-7 7a.5.5 0 0 1-.708 0" />
                                <path d="m5.354 7.146.896.897-.707.707-.897-.896a.5.5 0 1 1 .708-.708" />
                            </svg>
                        </span>
                        Mark as read</button>
                </div>
                <a href="{{ $details }}" class="btn btn-outline-secondary btn-sm icon-link rounded-3" data-leave-check="true"><svg
                        xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-eye" viewBox="0 0 16 16">
                        <path
                            d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z" />
                        <path
                            d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                    </svg>Details</a>
            </div>
        </div>
    </template>
</div>
