import {
    IconId,
    IconCircleCheck,
    IconCalendar,
    IconCoins,
    IconArrowDownCircle,
    IconUsers,
} from "@tabler/icons-react";

export default function AccountOverview({ user, profile }) {

    const items = [

        {
            icon: IconId,
            label: "Client ID",
            value: user?.id,
        },

        {
            icon: IconCircleCheck,
            label: "Account Status",
            value: "Active",
            color: "green",
        },

        {
            icon: IconCalendar,
            label: "Registration Date",
            value: new Date(profile.created_at).toLocaleDateString(
                "en-GB",
                {
                    day: "2-digit",
                    month: "short",
                    year: "numeric",
                }
            ),
        },

        {
            icon: IconCoins,
            label: "Deposit Rate",
            value: `৳ ${profile.deposit_rate}`,
        },

        {
            icon: IconArrowDownCircle,
            label: "Withdraw Rate",
            value: `৳ ${profile.withdraw_rate}`,
        },

        {
            icon: IconUsers,
            label: "Team Members",
            value: `${profile.aCount + profile.bCount} (${profile.aCount} A | ${profile.bCount} B)`,
        },

    ];

    return (

        <div className="card mb-4">

            <div className="card-header">

                <h3 className="card-title">

                    Account Overview

                </h3>

            </div>

            <div className="table-responsive">

                <table className="table table-vcenter card-table">

                    <tbody>

                        {

                            items.map((item,index)=>{

                                const Icon=item.icon;

                                return(

                                    <tr key={index}>

                                        <td width="45">

                                            <Icon
                                                className={
                                                    item.color
                                                    ?
                                                    `text-${item.color}`
                                                    :
                                                    "text-primary"
                                                }
                                                size={22}
                                            />

                                        </td>

                                        <td>

                                            {item.label}

                                        </td>

                                        <td className="text-end fw-bold">

                                            {

                                                item.color

                                                ?

                                                <span className={`badge bg-${item.color}`}>

                                                    {item.value}

                                                </span>

                                                :

                                                item.value

                                            }

                                        </td>

                                    </tr>

                                );

                            })

                        }

                    </tbody>

                </table>

            </div>

        </div>

    );

}