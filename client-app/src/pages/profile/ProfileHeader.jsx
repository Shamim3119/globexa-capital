import {
    IconPhone,
    IconMail,
    IconCalendar,
    IconEdit,
    IconCircleCheck,
} from "@tabler/icons-react";

export default function ProfileHeader({
    user,
    profile,
    onEdit,
}) {

    const joinDate = profile?.created_at
        ? new Date(
              profile.created_at
          ).toLocaleDateString("en-GB", {
              day: "2-digit",
              month: "short",
              year: "numeric",
          })
        : "-";


    const avatar = user?.photo
        ? `${import.meta.env.VITE_API_URL.replace(
              "/api",
              ""
          )}/storage/${user.photo}`
        : `https://ui-avatars.com/api/?name=${encodeURIComponent(
              user?.name || "User"
          )}&background=003366&color=ffffff&size=200`;


    return (

        <div className="card shadow-sm border-0 mb-4">

            <div className="card-body p-4">

                <div className="row align-items-center">

                    {/* Avatar */}

                    <div className="col-lg-2 text-center">

                        <img
                            src={avatar}
                            alt={user?.name}
                            className="rounded-circle shadow"
                            style={{
                                width: 120,
                                height: 120,
                                objectFit: "cover",
                            }}
                        />

                    </div>


                    {/* User Info */}

                    <div className="col-lg-7 mt-3 mt-lg-0">

                        <div className="d-flex align-items-center">

                            <h2 className="mb-0 me-3">
                                {user?.name}
                            </h2>


                            <span className="badge bg-green-lt text-green">

                                <IconCircleCheck
                                    size={16}
                                    className="me-1"
                                />

                                Active

                            </span>

                        </div>


                        <div className="text-secondary mt-2">

                            Client ID :

                            <strong className="ms-1">
                                {user?.id}
                            </strong>

                        </div>


                        <div className="text-secondary">

                            <IconCalendar
                                size={18}
                                className="me-2"
                            />

                            Member Since {joinDate}

                        </div>


                        <div className="mt-4">

                            <div className="mb-2">

                                <IconPhone
                                    size={18}
                                    className="me-2 text-primary"
                                />

                                {profile?.phone || "-"}

                            </div>


                            <div>

                                <IconMail
                                    size={18}
                                    className="me-2 text-primary"
                                />

                                {profile?.email || "-"}

                            </div>

                        </div>

                    </div>


                    {/* Right Side */}

                    <div className="col-lg-3 text-lg-end mt-4 mt-lg-0">

                        <button
                            type="button"
                            className="btn btn-primary"
                            onClick={onEdit}
                        >

                            <IconEdit
                                size={18}
                                className="me-2"
                            />

                            Edit Profile

                        </button>

                    </div>

                </div>

            </div>

        </div>

    );

}