 
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
import Transfer from "../pages/transfer/Transfer";
import P2P from "../pages/p2p/P2P";
import Refund from "../pages/refund/Refund";
import Account from "../pages/account/Account";
import Incomes from "../pages/incomes/Incomes";
import CompanyDocuments from "../pages/company-documents/CompanyDocuments";
import ForgotPassword from "../pages/auth/ForgotPassword";

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

                <Route
                    path="/forgot-password"
                    element={<ForgotPassword />}
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

                    <Route 
                        path="/transfer" 
                        element={<Transfer />} 
                    />

                    <Route 
                        path="/p2p" 
                        element={<P2P />} 
                    />
                    
                    <Route
                        path="/refund"
                        element={<Refund />}
                    />
 

                    <Route
                        path="/account"
                        element={<Account />}
                    />

                    <Route
                        path="/incomes"
                        element={<Incomes />}
                    />  

                    <Route
                        path="/company-documents"
                        element={<CompanyDocuments />}
                    />

                    

                </Route>


            </Routes>


        </BrowserRouter>

    );

}


 