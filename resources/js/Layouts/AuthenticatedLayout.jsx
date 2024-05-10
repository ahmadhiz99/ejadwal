import { useState,useEffect } from "react";
import ApplicationLogo from "@/Components/ApplicationLogo";
import Dropdown from "@/Components/Dropdown";
import NavLink from "@/Components/NavLink";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink";
import { Head, Link,usePage } from "@inertiajs/react";
import { ToastContainer, toast } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";
// import {useParams} from 'react-router-dom';

export default function Authenticated({ user, header, children }) {
    const [showingNavigationDropdown, setShowingNavigationDropdown] =
        useState(false);

    // const {menuId} = useParams();
    // const data = usePage().props.data;
    const [menuData,setMenuData] = useState([]);
    const [showSubMenu, setShowSubMenu] = useState(false);

    // Toggle submenu
    // const toggleSubMenu = (index) =>{
    //     setMenuData(prevMenuData => {
    //         const updatedMenuData = [ ...prevMenuData];
    //         updatedMenuData[index].showSubMenu = !updatedMenuData[index].showSubMenu;
    //         return updatedMenuData;
    //     });
    // }
    const toggleSubMenu = (menuId) => {
        setShowSubMenu(prevShowSubMenu =>(prevShowSubMenu === menuId ? null : menuId));
    };

    useEffect(()=>{
        const fetchData = async () =>{
            try{
                const response = await fetch('/menu-page');
                const data = await response.json();
                const menuDataWithSubMenu = data.data.data.map(item => ({...item,showSubMenu:false}));
                setMenuData(menuDataWithSubMenu);
                // setMenuData(data.data.data);
            }catch(error){
                console.error('Error Fetching menu data:',error);
            }
        }

        fetchData();
    },[])

    return (
        <div className="flex flex-row min-h-screen bg-gray-100">
            <Head>
                <link
                    href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
                    rel="stylesheet"
                ></link>
            </Head>
            <div className="bg-blue-900 w-80 p-4">
                <div className="flex flex-row gap-2 mb-5">
                    <img
                        src="/assets/images/upy.png"
                        className="w-14 h-14"
                        alt=""
                    />
                    <div className="flex flex-col text-white">
                        <h1
                            onClick={() => toast.success("halo")}
                            className="font-bold text-2xl"
                        >
                            E-Jadwal
                        </h1>
                        <p className="text-xs">Fakultas Sains dan Teknologi</p>
                    </div>
                </div>
                <div className="flex flex-col gap-2">
                    {menuData?.map(menuData =>(
                    // console.log((menuData.subMenus).length),
                    (menuData.subMenus).length == 0 ? 
                        <div key={menuData.id}>
                            <NavLink
                                href={route(`${menuData.route}`)}
                                active={route().current(`${menuData.activeRoute}`)}
                                className="nav-link"
                            >
                                 <i className={`nav-link bx bx-sm ${menuData.icon} mr-2`}></i>{menuData.name}
                            </NavLink>
                        </div>
                :
                    <div key={menuData.id}>
                            <div
                                className="w-full p-3 inline-flex items-center border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out focus:outline-none border-transparent text-white hover:bg-blue-950 "
                                onClick={()=>toggleSubMenu(menuData.id)}
                                
                                style={{cursor:'pointer'}}
                            >
                                <i className={`nav-link bx bx-sm ${menuData.icon} mr-2`}></i>{menuData.name}
                            </div>
                            
                            {showSubMenu === menuData.id && menuData.subMenus && (
                                <ul style={{
                                    overflow: 'hidden',
                                    transition: 'max-height 0.5s ease-out'
                                }}>
                                    {menuData.subMenus.map(subMenu => (
                                        
                                        <li >
                                            <NavLink
                                                href={route(`${subMenu.route}`)}
                                                active={route().current(`${subMenu.activeRoute}`)}
                                                className="nav-link"
                                            >
                                                <i className="bx bx-sm bx-bowling-ball mr-2 pl-6"></i>{subMenu.name}
                                            </NavLink>
                                        
                                        </li>
                                    ))}
                                 </ul>
                            )}
                          
                         
                     </div>
                    ))}
                    
                </div>
            </div>
            <main className="w-full">
                <nav className="bg-white border-b border-gray-100">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div className="flex items-center justify-between h-16">
                            <i className="bx bx-sm bx-menu"></i>
                            {/* <div className="flex">
                                <div className="shrink-0 flex items-center">
                                    <Link href="/">
                                        <ApplicationLogo className="block h-9 w-auto fill-current text-gray-800" />
                                    </Link>
                                </div>

                                <div className="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                                    <NavLink
                                        href={route("dashboard")}
                                        active={route().current("dashboard")}
                                    >
                                        Dashboard
                                    </NavLink>
                                </div>
                            </div> */}

                            <div className="hidden sm:flex sm:items-center sm:ms-6">
                                <div className="ms-3 relative">
                                    <Dropdown>
                                        <Dropdown.Trigger>
                                            <span className="inline-flex rounded-md">
                                                <button
                                                    type="button"
                                                    className="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"
                                                >
                                                    {user.name}

                                                    <svg
                                                        className="ms-2 -me-0.5 h-4 w-4"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 20 20"
                                                        fill="currentColor"
                                                    >
                                                        <path
                                                            fillRule="evenodd"
                                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                            clipRule="evenodd"
                                                        />
                                                    </svg>
                                                </button>
                                            </span>
                                        </Dropdown.Trigger>

                                        <Dropdown.Content>
                                            <Dropdown.Link
                                                href={route("profile.edit")}
                                            >
                                                Profile
                                            </Dropdown.Link>
                                            <Dropdown.Link
                                                href={route("logout")}
                                                method="post"
                                                as="button"
                                            >
                                                Log Out
                                            </Dropdown.Link>
                                        </Dropdown.Content>
                                    </Dropdown>
                                </div>
                            </div>

                            <div className="-me-2 flex items-center sm:hidden">
                                <button
                                    onClick={() =>
                                        setShowingNavigationDropdown(
                                            (previousState) => !previousState
                                        )
                                    }
                                    className="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out"
                                >
                                    <svg
                                        className="h-6 w-6"
                                        stroke="currentColor"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            className={
                                                !showingNavigationDropdown
                                                    ? "inline-flex"
                                                    : "hidden"
                                            }
                                            strokeLinecap="round"
                                            strokeLinejoin="round"
                                            strokeWidth="2"
                                            d="M4 6h16M4 12h16M4 18h16"
                                        />
                                        <path
                                            className={
                                                showingNavigationDropdown
                                                    ? "inline-flex"
                                                    : "hidden"
                                            }
                                            strokeLinecap="round"
                                            strokeLinejoin="round"
                                            strokeWidth="2"
                                            d="M6 18L18 6M6 6l12 12"
                                        />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div
                        className={
                            (showingNavigationDropdown ? "block" : "hidden") +
                            " sm:hidden"
                        }
                    >
                        <div className="pt-2 pb-3 space-y-1">
                            <ResponsiveNavLink
                                href={route("dashboard")}
                                active={route().current("dashboard")}
                            >
                                Dashboard
                            </ResponsiveNavLink>
                        </div>

                        <div className="pt-4 pb-1 border-t border-gray-200">
                            <div className="px-4">
                                <div className="font-medium text-base text-gray-800">
                                    {user.name}
                                </div>
                                <div className="font-medium text-sm text-gray-500">
                                    {user.email}
                                </div>
                            </div>

                            <div className="mt-3 space-y-1">
                                <ResponsiveNavLink href={route("profile.edit")}>
                                    Profile
                                </ResponsiveNavLink>
                                <ResponsiveNavLink
                                    method="post"
                                    href={route("logout")}
                                    as="button"
                                >
                                    Log Out
                                </ResponsiveNavLink>
                            </div>
                        </div>
                    </div>
                </nav>
                {children}
            </main>
        </div>
    );
}
