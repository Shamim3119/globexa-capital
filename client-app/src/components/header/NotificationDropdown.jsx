import {
    IconBell,
    IconCash,
    IconUsers,
    IconWallet,
} from "@tabler/icons-react";

export default function NotificationDropdown() {

    const notifications = [

        {
            id:1,
            title:"Deposit Approved",
            text:"Your deposit has been approved.",
            icon:IconCash,
            color:"green",
            time:"10 minutes ago",
        },

        {
            id:2,
            title:"New Team Member",
            text:"A new member joined Team A.",
            icon:IconUsers,
            color:"blue",
            time:"1 hour ago",
        },

        {
            id:3,
            title:"Income Added",
            text:"Income has been credited.",
            icon:IconWallet,
            color:"yellow",
            time:"Today",
        },

    ];

    return (

        <div className="nav-item dropdown">

            <button
                className="btn btn-icon position-relative"
                data-bs-toggle="dropdown"
                type="button"
            >

                <IconBell size={20}/>

                <span className="badge bg-red badge-notification">
                    {notifications.length}
                </span>

            </button>

            <div
                className="dropdown-menu dropdown-menu-end dropdown-menu-card"
                style={{width:"360px"}}
            >

                <div className="card">

                    <div className="card-header">

                        <h3 className="card-title">

                            Notifications

                        </h3>

                    </div>

                    <div className="list-group list-group-flush">

                        {notifications.map(item=>{

                            const Icon=item.icon;

                            return(

                                <div
                                    key={item.id}
                                    className="list-group-item"
                                >

                                    <div className="row align-items-center">

                                        <div className="col-auto">

                                            <span className={`status-dot bg-${item.color}`}></span>

                                        </div>

                                        <div className="col-auto">

                                            <span className={`avatar bg-${item.color}-lt`}>

                                                <Icon
                                                    size={18}
                                                    className={`text-${item.color}`}
                                                />

                                            </span>

                                        </div>

                                        <div className="col">

                                            <div>

                                                {item.title}

                                            </div>

                                            <div className="text-secondary small">

                                                {item.text}

                                            </div>

                                        </div>

                                        <div className="col-auto text-secondary small">

                                            {item.time}

                                        </div>

                                    </div>

                                </div>

                            );

                        })}

                    </div>

                    <div className="card-footer text-center">

                        <a href="#">

                            View all notifications

                        </a>

                    </div>

                </div>

            </div>

        </div>

    );

}