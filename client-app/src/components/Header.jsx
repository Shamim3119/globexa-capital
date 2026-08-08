import {
    IconMenu2
} from "@tabler/icons-react";


import ThemeToggle from "./header/ThemeToggle";
import NotificationDropdown from "./header/NotificationDropdown";
import UserDropdown from "./header/UserDropdown";


import { useSidebar } from "../context/SidebarContext";



export default function Header(){


    const {
        toggleSidebar,
        toggleMobileSidebar
    } = useSidebar();



    const handleMenu = ()=>{


        if(window.innerWidth < 991){

            toggleMobileSidebar();

        }else{

            toggleSidebar();

        }

    };



    return (

        <header className="navbar navbar-expand-md d-print-none">


            <div className="container-fluid">


                <button

                    type="button"

                    className="navbar-toggler d-flex"

                    onClick={handleMenu}

                >

                    <IconMenu2 size={22}/>

                </button>



                <div className="navbar-brand">

                    Globexa Capital

                </div>



                <div className="navbar-nav flex-row ms-auto">


                    <ThemeToggle />

                    <NotificationDropdown />

                    <UserDropdown />


                </div>


            </div>


        </header>

    );

}