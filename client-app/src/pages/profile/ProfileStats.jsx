import {
    IconWallet,
    IconChartLine,
    IconCoins,
    IconUsers,
} from "@tabler/icons-react";

export default function ProfileStats({ profile }) {

    const stats = [

        {
            title: "Deposit Balance",
            value: `৳ ${profile.deposit_balance}`,
            subtitle: "Available Balance",
            icon: IconWallet,
            color: "primary",
        },

        {
            title: "Investment Balance",
            value: `৳ ${profile.investment_balance}`,
            subtitle: "Running Investment",
            icon: IconChartLine,
            color: "green",
        },

        {
            title: "Income Balance",
            value: `৳ ${profile.income_balance}`,
            subtitle: "Total Earnings",
            icon: IconCoins,
            color: "orange",
        },

        {
            title: "Team A",
            value: profile.aCount,
            subtitle: "Members",
            icon: IconUsers,
            color: "blue",
        },

        {
            title: "Team B",
            value: profile.bCount,
            subtitle: "Members",
            icon: IconUsers,
            color: "purple",
        },

    ];

    return (

        <div className="row row-cards mb-4">

            {
                stats.map((item,index)=>{

                    const Icon=item.icon;

                    return(

                        <div
                            className="col-sm-6 col-lg"
                            key={index}
                        >

                            <div className="card">

                                <div className="card-body">

                                    <div className="d-flex align-items-center">

                                        <div
                                            className={`bg-${item.color}-lt rounded p-3 me-3`}
                                        >

                                            <Icon
                                                size={28}
                                                className={`text-${item.color}`}
                                            />

                                        </div>

                                        <div>

                                            <div className="text-secondary">

                                                {item.title}

                                            </div>

                                            <div className="h2 mb-0">

                                                {item.value}

                                            </div>

                                            <small className="text-secondary">

                                                {item.subtitle}

                                            </small>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    );

                })
            }

        </div>

    );

}