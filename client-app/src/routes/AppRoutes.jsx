 
import {
    BrowserRouter,
    Routes,
    Route
} from "react-router-dom";


import Login from "../pages/auth/Login";

import Dashboard from "../pages/dashboard/Dashboard";

import Deposit from "../pages/deposit/Deposit";
import Investment from "../pages/investment/Investment";
import Withdraw from "../pages/withdraw/Withdraw";
import Team from "../pages/team/Team";
import Profile from "../pages/profile/Profile";


import DashboardLayout from "../layouts/DashboardLayout";

import ProtectedRoute from "./ProtectedRoute";



export default function AppRoutes(){


    return (

        <BrowserRouter>

            <Routes>


                {/* Login */}

                <Route

                    path="/"

                    element={<Login />}

                />



                {/* Protected Pages */}

                <Route


                    element={


                        <ProtectedRoute>


                            <DashboardLayout />


                        </ProtectedRoute>


                    }


                >


                    <Route
                    path="/dashboard"
                    element={
                    <ProtectedRoute>
                        <Dashboard />
                    </ProtectedRoute>
                    }
                    /> 


                    <Route

                        path="/deposit"

                        element={<Deposit />}

                    />


                    <Route

                        path="/investment"

                        element={<Investment />}

                    />


                    <Route

                        path="/withdraw"

                        element={<Withdraw />}

                    />


                    <Route

                        path="/team"

                        element={<Team />}

                    />


                    <Route

                        path="/profile"

                        element={<Profile />}

                    />


                </Route>


            </Routes>


        </BrowserRouter>

    );

}




{/*

import {
    BrowserRouter,
    Routes,
    Route
} from "react-router-dom";


import Login from "../pages/auth/Login";

import Dashboard from "../pages/dashboard/Dashboard";

import Deposit from "../pages/deposit/Deposit";
import Investment from "../pages/investment/Investment";
import Withdraw from "../pages/withdraw/Withdraw";
import Team from "../pages/team/Team";
import Profile from "../pages/profile/Profile";


import DashboardLayout from "../layouts/DashboardLayout";

import ProtectedRoute from "./ProtectedRoute";


export default function AppRoutes(){

    return (

        <BrowserRouter basename="/client">

            <Routes>

 
                <Route
                    path="/"
                    element={<Login />}
                />


 
                <Route

                    element={
                        <ProtectedRoute>
                            <DashboardLayout />
                        </ProtectedRoute>
                    }

                >

                    <Route
                        path="/dashboard"
                        element={<Dashboard />}
                    />


                    <Route
                        path="/deposit"
                        element={<Deposit />}
                    />


                    <Route
                        path="/investment"
                        element={<Investment />}
                    />


                    <Route
                        path="/withdraw"
                        element={<Withdraw />}
                    />


                    <Route
                        path="/team"
                        element={<Team />}
                    />


                    <Route
                        path="/profile"
                        element={<Profile />}
                    />

                </Route>


            </Routes>

        </BrowserRouter>

    );
}


*/}