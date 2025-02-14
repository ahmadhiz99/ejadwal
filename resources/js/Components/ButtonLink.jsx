import { Link } from "@inertiajs/react";

export default function ButtonLink({
    className = "",
    href,
    children,
    ...props
}) {
    return (
        <Link
            className={
                `inline-flex items-center px-4 py-2 bg-sky-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-sky-700 focus:bg-sky-700 active:bg-sky-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ` +
                className
            }
            href={route(href)}
        >
            {children}
        </Link>
    );
}
