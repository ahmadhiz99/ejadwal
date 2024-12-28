import { Head, router, usePage } from "@inertiajs/react";
import { ToastContainer, toast } from "react-toastify";
import "react-toastify/dist/ReactToastify.css"; // Import Toastify CSS for styling

export default function Notif({ auth }) {
    const { data, flash } = usePage().props;

    // Show a toast if a message is passed in the flash prop
    if (flash.toast) {
        toast.error(flash.toast);  // Show an error toast
    }

    return (
        <div>
            <Head title="Table Builder" />
            
            <h1>Welcome, Tests</h1>


            {/* ToastContainer: This will display the toast notifications */}
            <ToastContainer
                position="top-right"
                autoClose={5000}
                hideProgressBar={false}
                newestOnTop
                closeOnClick
                rtl={false}
                pauseOnFocusLoss
                draggable
                pauseOnHover
            />
        </div>
    );
}
