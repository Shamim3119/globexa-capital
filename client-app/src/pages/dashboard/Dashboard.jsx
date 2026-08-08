import {
    IconWallet,
    IconChartLine,
    IconCoin
} from "@tabler/icons-react";


import {useAuth} from "../../context/AuthContext";


import WelcomeCard from "../../components/dashboard/WelcomeCard";
import BalanceCard from "../../components/dashboard/BalanceCard";
import TeamCard from "../../components/dashboard/TeamCard";
import QuickActions from "../../components/dashboard/QuickActions";

import {useDashboard} from "../../context/DashboardContext";
import Loader from "../../components/Loader";
 
export default function Dashboard(){



    const {user}=useAuth();


    const {
        dashboard,
        loading
    } = useDashboard();



    if(loading){

        return <Loader/>;

    }

 

    return (

        <>


        <WelcomeCard user={user}/>



        <div className="row mt-3">


            <BalanceCard

            title="Deposit Balance"
            value={user?.deposit_balance}
 

            icon={IconWallet}

            color="blue"

            />


            <BalanceCard

            title="Investment"

            value={user?.investment_balance}

            icon={IconChartLine}

            color="green"

            />


            <BalanceCard

            title="Income"

            value={user?.income_balance}

            icon={IconCoin}

            color="yellow"

            />


        </div>




        <div className="mt-3">

            <TeamCard user={user}/>

        </div>




        <div className="mt-3">

            <QuickActions/>

        </div>


        </>

    );

}