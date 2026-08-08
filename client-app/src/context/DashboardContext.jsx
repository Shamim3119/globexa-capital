import {
    createContext,
    useContext,
    useEffect,
    useState
} from "react";


import api from "../api/api";

import {useAuth} from "./AuthContext";


const DashboardContext = createContext();



export function DashboardProvider({children}){


    const {user}=useAuth();


    const [dashboard,setDashboard]=useState(null);

    const [loading,setLoading]=useState(true);



    useEffect(()=>{


        if(user?.id){

            loadDashboard();

        }


    },[user]);




    const loadDashboard=async()=>{


        try{


            const res=await api.get(
                "/dashboard-summary",
                {
                    params:{
                        id:user.id
                    }
                }
            );



            if(res.data.success){

                setDashboard(res.data);

            }



        }
        catch(error){

            console.log(error);

        }
        finally{

            setLoading(false);

        }


    };




    return (

        <DashboardContext.Provider

            value={{
                dashboard,
                loading,
                loadDashboard
            }}

        >

            {children}

        </DashboardContext.Provider>

    );

}




export function useDashboard(){

    return useContext(DashboardContext);

}