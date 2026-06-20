<?php

 
namespace App\Helpers;

class Toast
{
    public static function get_toast_message()
    {
        return "<script>
                    document.addEventListener('show-toast', (event) => {
                    document.getElementById('messageToast').innerText = event.detail.message;
                    const toastElement = document.getElementById('successToast');
                    const toast = new bootstrap.Toast(toastElement);
                    toast.show();
                });
                </script>

            <div class='position-fixed top-0 end-0 mt-5 p-3' style='z-index: 11'>
                <div id='successToast' class='toast text-bg-success' role='alert' aria-live='assertive' aria-atomic='true'>
                    <div class='toast-header'>
                        <strong class='me-auto'>Success</strong>
                        <small>just now</small>
                        <button type='button' class='btn-close' data-bs-dismiss='toast'></button>
                    </div>
                    <div class='toast-body' id='messageToast'>
                        Hello, world!
                    </div>
                </div>
            </div>";
    }

}