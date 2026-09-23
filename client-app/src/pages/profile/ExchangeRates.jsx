import {
    IconTrendingUp,
    IconTrendingDown,
} from "@tabler/icons-react";

export default function ExchangeRates({ profile }) {

    const rates = [

        {
            title: "Deposit Rate",
            value: profile.deposit_rate,
            subtitle: "Today's Deposit Rate",
            icon: IconTrendingUp,
            color: "green",
        },

        {
            title: "Withdraw Rate",
            value: profile.withdraw_rate,
            subtitle: "Current Withdraw Rate",
            icon: IconTrendingDown,
            color: "red",
        },

    ];

    return (

        <div className="row row-cards mb-4">

            {

                rates.map((item,index)=>{

                    const Icon = item.icon;

                    return(

                        <div
                            className="col-md-6"
                            key={index}
                        >

                            <div className="card">

                                <div className="card-body">

                                    <div className="d-flex justify-content-between">

                                        <div>

                                            <div className="text-secondary">

                                                {item.title}

                                            </div>

                                            <div className="display-6 fw-bold mt-2">

                                                $ {item.value}

                                            </div>

                                            <div className="text-secondary mt-2">

                                                {item.subtitle}

                                            </div>

                                        </div>

                                        <div>

                                            <span
                                                className={`avatar avatar-lg bg-${item.color}-lt`}
                                            >

                                                <Icon
                                                    size={30}
                                                    className={`text-${item.color}`}
                                                />

                                            </span>

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