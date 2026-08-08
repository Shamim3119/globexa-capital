import {
    IconPhone,
    IconMail,
    IconHome,
    IconCalendar,
} from "@tabler/icons-react";

export default function PersonalInfo({ profile }) {

    const joinDate = profile?.created_at
        ? new Date(profile.created_at).toLocaleDateString("en-GB", {
              day: "2-digit",
              month: "short",
              year: "numeric",
          })
        : "-";

    const items = [

        {
            icon: IconPhone,
            label: "Phone",
            value: profile.phone,
        },

        {
            icon: IconMail,
            label: "Email",
            value: profile.email,
        },

        {
            icon: IconHome,
            label: "Address",
            value: profile.address,
        },

        {
            icon: IconCalendar,
            label: "Registration Date",
            value: joinDate,
        },

    ];

    return (

        <div className="card mb-4">

            <div className="card-header">

                <h3 className="card-title">

                    Personal Information

                </h3>

            </div>

            <div className="card-body">

                <div className="row">

                    {
                        items.map((item,index)=>{

                            const Icon=item.icon;

                            return(

                                <div
                                    className="col-md-6 mb-4"
                                    key={index}
                                >

                                    <div className="d-flex">

                                        <div
                                            className="avatar avatar-md bg-primary-lt me-3"
                                        >

                                            <Icon
                                                size={22}
                                                className="text-primary"
                                            />

                                        </div>

                                        <div>

                                            <div className="text-secondary small">

                                                {item.label}

                                            </div>

                                            <div className="fw-bold">

                                                {item.value || "-"}

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            );

                        })
                    }

                </div>

            </div>

        </div>

    );

}