import { useEffect, useState } from "react";

import {
    IconPhone,
    IconMail,
    IconHome,
    IconCalendar,
    IconUsers,
    IconCopy,
    IconWallet,
    IconChartLine,
    IconArrowDownCircle,
} from "@tabler/icons-react";


import api from "../../api/api";
import Loader from "../../components/Loader";
import { useAuth } from "../../context/AuthContext";
import ProfileHeader from "./ProfileHeader";
import ProfileStats from "./ProfileStats";
import PersonalInfo from "./PersonalInfo";
import ReferralCard from "./ReferralCard";
import ExchangeRates from "./ExchangeRates";
import AccountOverview from "./AccountOverview";
import PageHeader from "./PageHeader";

export default function Profile(){


    const { user } = useAuth();

    const [profile,setProfile] = useState(null);

    const [loading,setLoading] = useState(true);



    useEffect(()=>{

        if(user?.id){

            loadProfile();

        }

    },[user]);




    const loadProfile = async()=>{

        try{

            const res = await api.get(
                "/get-profile",
                {
                    params:{
                        id:user.id
                    }
                }
            );


            if(res.data.success){

                setProfile(res.data.user);

            }


        }
        catch(error){

            console.log(error);

        }
        finally{

            setLoading(false);

        }

    };



 



    if(loading){

        return <Loader/>;

    }

    return (

        <div>

            <PageHeader />


            <ProfileHeader
                user={user}
                profile={profile}
            />


            <ProfileStats
                profile={profile}
            />
 
            <PersonalInfo
                profile={profile}
            />

            <AccountOverview
                user={user}
                profile={profile}
            />
 
            <div className="row row-cards mb-4">

                <div className="col-md-6">

                    <ReferralCard

                        title="Team A Referral"

                        count={profile.aCount}

                        link={profile.aLink}

                    />

                </div>

                <div className="col-md-6">

                    <ReferralCard

                        title="Team B Referral"

                        count={profile.bCount}

                        link={profile.bLink}

                    />

                </div>

            </div>

            <ExchangeRates
                profile={profile}
            />


        </div>

    );


}


 



 