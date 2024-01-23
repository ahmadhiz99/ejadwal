import { Link } from "@inertiajs/react";

export default function NavLink({
    active = false,
    className = "",
    children,
    ...props
}) {
    return (
        <Link
            {...props}
            className={
                "w-full p-3 inline-flex items-center border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out focus:outline-none " +
                (active
                    ? "text-white rounded-sm bg-blue-950 border-blue-400 "
                    : "border-transparent text-white hover:bg-blue-950 ") +
                className
            }
        >
            {children}
        </Link>
    );
}
