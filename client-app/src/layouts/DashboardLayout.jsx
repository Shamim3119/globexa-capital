import { Outlet } from "react-router-dom";

import Sidebar from "../components/Sidebar";
import Header from "../components/Header";

import { useSidebar } from "../context/SidebarContext";


export default function DashboardLayout(){


    const {
        collapsed,
        mobileOpen,
        closeMobileSidebar
    } = useSidebar();



    return (

    <div
        className={
            collapsed
            ?
            "page sidebar-collapsed"
            :
            "page"
        }
    >

        <Sidebar />


        {
            mobileOpen &&
            <div
                className="sidebar-overlay"
                onClick={closeMobileSidebar}
            ></div>
        }


        <div className="page-wrapper">

            <Header />

            <div className="page-body">

                <div className="container-xl">

                    <Outlet />

                </div>

            </div>

        </div>

    </div>

    );

}