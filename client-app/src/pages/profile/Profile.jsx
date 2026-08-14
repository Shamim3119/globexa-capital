import {
    IconDeviceFloppy,
} from "@tabler/icons-react";

import { useEffect, useState } from "react";

import api from "../../api/api";
import Loader from "../../components/Loader";
import { useAuth } from "../../context/AuthContext";
import { useToast } from "../../context/ToastContext";

import ProfileHeader from "./ProfileHeader";
import ProfileStats from "./ProfileStats";
import PersonalInfo from "./PersonalInfo";
import ReferralCard from "./ReferralCard";
import ExchangeRates from "./ExchangeRates";
import AccountOverview from "./AccountOverview";
import PageHeader from "./PageHeader";

export default function Profile() {

    const { user, login } = useAuth();
    const { showToast } = useToast();

    const [profile, setProfile] = useState(null);
    const [loading, setLoading] = useState(true);

    const [editOpen, setEditOpen] = useState(false);

    const [form, setForm] = useState({
        name: "",
        phone: "",
        email: "",
        address: "",
    });

    const [image, setImage] = useState(null);
    const [imagePreview, setImagePreview] = useState("");

    const [saving, setSaving] = useState(false);


    /*
    |--------------------------------------------------------------------------
    | Load Profile
    |--------------------------------------------------------------------------
    */

    const loadProfile = async () => {

        if (!user?.id) {
            return;
        }

        try {

            setLoading(true);

            const res = await api.get(
                "/get-profile",
                {
                    params: {
                        id: user.id,
                    },
                }
            );

            if (res.data.success) {

                setProfile(res.data.user);

            } else {

                showToast(
                    res.data.message ||
                    "Failed to load profile.",
                    "danger"
                );

            }

        } catch (error) {

            console.error(
                "Profile Error:",
                error
            );

            showToast(
                error?.response?.data?.message ||
                "Failed to load profile.",
                "danger"
            );

        } finally {

            setLoading(false);

        }

    };


    useEffect(() => {

        loadProfile();

    }, [user?.id]);


    /*
    |--------------------------------------------------------------------------
    | Open Edit
    |--------------------------------------------------------------------------
    */

    const handleEdit = () => {

        setForm({
            name: profile?.name || user?.name || "",
            phone: profile?.phone || user?.phone || "",
            email: profile?.email || user?.email || "",
            address: profile?.address || user?.address || "",
        });

        setImage(null);

        setImagePreview("");

        setEditOpen(true);

    };


    /*
    |--------------------------------------------------------------------------
    | Close Edit
    |--------------------------------------------------------------------------
    */

    const handleCloseEdit = () => {

        if (saving) {
            return;
        }

        setEditOpen(false);

        setImage(null);

        setImagePreview("");

    };


    /*
    |--------------------------------------------------------------------------
    | Form Change
    |--------------------------------------------------------------------------
    */

    const handleChange = (field, value) => {

        setForm((previous) => ({
            ...previous,
            [field]: value,
        }));

    };


    /*
    |--------------------------------------------------------------------------
    | Image Change
    |--------------------------------------------------------------------------
    */

    const handleImageChange = (e) => {

        const file =
            e.target.files?.[0] || null;

        if (!file) {
            return;
        }


        if (!file.type.startsWith("image/")) {

            showToast(
                "Please select an image file.",
                "danger"
            );

            return;

        }


        setImage(file);

        setImagePreview(
            URL.createObjectURL(file)
        );

    };


    /*
    |--------------------------------------------------------------------------
    | Update Profile
    |--------------------------------------------------------------------------
    */

    const updateProfile = async (e) => {

        e.preventDefault();

        if (!user?.id) {

            showToast(
                "User information is not available.",
                "danger"
            );

            return;

        }


        try {

            setSaving(true);


            const formData = new FormData();

            formData.append(
                "id",
                String(user.id)
            );

            formData.append(
                "name",
                form.name
            );

            formData.append(
                "phone",
                form.phone
            );

            formData.append(
                "email",
                form.email
            );

            formData.append(
                "address",
                form.address
            );


            if (image) {

                formData.append(
                    "photo",
                    image
                );

            }


            const response = await api.post(
                "/update-profile",
                formData,
                {
                    headers: {
                        Accept:
                            "application/json",
                        "Content-Type":
                            "multipart/form-data",
                    },
                }
            );


            const res = response.data;


            if (res.success) {

                showToast(
                    res.message ||
                    "Profile updated successfully.",
                    "success"
                );


                /*
                |--------------------------------------------------------------------------
                | Update Auth User
                |--------------------------------------------------------------------------
                */

                if (res.user) {

                    login(res.user);

                }


                /*
                |--------------------------------------------------------------------------
                | Refresh Profile
                |--------------------------------------------------------------------------
                */

                await loadProfile();


                setEditOpen(false);

                setImage(null);

                setImagePreview("");

            } else {

                showToast(
                    res.message ||
                    "Failed to update profile.",
                    "danger"
                );

            }

        } catch (error) {

            console.error(
                "Update Profile Error:",
                error
            );


            if (
                error?.response?.data?.errors
            ) {

                const errors =
                    error.response.data.errors;

                const firstError =
                    Object.values(errors)
                        .flat()[0];

                showToast(
                    firstError ||
                    "Validation failed.",
                    "danger"
                );

            } else {

                showToast(
                    error?.response?.data?.message ||
                    "Failed to update profile.",
                    "danger"
                );

            }

        } finally {

            setSaving(false);

        }

    };


    /*
    |--------------------------------------------------------------------------
    | Loading
    |--------------------------------------------------------------------------
    */

    if (loading) {

        return <Loader />;

    }


    return (

        <div>

            <PageHeader />


            <ProfileHeader
                user={user}
                profile={profile}
                onEdit={handleEdit}
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
                        count={profile?.aCount}
                        link={profile?.aLink}
                    />

                </div>


                <div className="col-md-6">

                    <ReferralCard
                        title="Team B Referral"
                        count={profile?.bCount}
                        link={profile?.bLink}
                    />

                </div>

            </div>


            <ExchangeRates
                profile={profile}
            />


            {/* Edit Profile Modal */}

            {editOpen && (

                <div
                    className="modal modal-blur fade show d-block"
                    tabIndex="-1"
                    role="dialog"
                    style={{
                        backgroundColor:
                            "rgba(0, 0, 0, 0.5)",
                    }}
                >

                    <div
                        className="modal-dialog modal-dialog-centered modal-lg"
                        role="document"
                    >

                        <div className="modal-content">

                            {/* Header */}

                            <div className="modal-header">

                                <h5 className="modal-title">
                                    Edit Profile
                                </h5>

                                <button
                                    type="button"
                                    className="btn-close"
                                    onClick={
                                        handleCloseEdit
                                    }
                                    disabled={saving}
                                    aria-label="Close"
                                />

                            </div>


                            {/* Form */}

                            <form
                                onSubmit={
                                    updateProfile
                                }
                            >

                                <div className="modal-body">

                                    {/* Photo */}

                                    <div className="text-center mb-4">

                                        <label
                                            htmlFor="profile-photo"
                                            style={{
                                                cursor:
                                                    "pointer",
                                            }}
                                        >

                                            <img
                                                src={
                                                    imagePreview ||
                                                    (
                                                        user?.photo
                                                            ? `${import.meta.env.VITE_API_URL.replace(
                                                                  "/api",
                                                                  ""
                                                              )}/storage/${user.photo}`
                                                            : `https://ui-avatars.com/api/?name=${encodeURIComponent(
                                                                  form.name ||
                                                                  "User"
                                                              )}&background=003366&color=ffffff&size=200`
                                                    )
                                                }
                                                alt={
                                                    form.name ||
                                                    "Profile"
                                                }
                                                className="rounded-circle shadow"
                                                style={{
                                                    width: 120,
                                                    height: 120,
                                                    objectFit:
                                                        "cover",
                                                }}
                                            />

                                        </label>


                                        <input
                                            id="profile-photo"
                                            type="file"
                                            accept="image/*"
                                            className="d-none"
                                            onChange={
                                                handleImageChange
                                            }
                                        />


                                        <div className="text-primary mt-2">
                                            Click image to change
                                        </div>

                                    </div>


                                    {/* Name */}

                                    <div className="mb-3">

                                        <label className="form-label">
                                            Full Name
                                        </label>

                                        <input
                                            type="text"
                                            className="form-control"
                                            value={
                                                form.name
                                            }
                                            onChange={(e) =>
                                                handleChange(
                                                    "name",
                                                    e.target.value
                                                )
                                            }
                                            placeholder="Name"
                                            disabled={saving}
                                        />

                                    </div>


                                    {/* Phone */}

                                    <div className="mb-3">

                                        <label className="form-label">
                                            Phone
                                        </label>

                                        <input
                                            type="text"
                                            className="form-control"
                                            value={
                                                form.phone
                                            }
                                            readOnly
                                            disabled
                                        />

                                        <div className="form-hint">
                                            Phone number cannot be changed.
                                        </div>

                                    </div>


                                    {/* Email */}

                                    <div className="mb-3">

                                        <label className="form-label">
                                            Email
                                        </label>

                                        <input
                                            type="email"
                                            className="form-control"
                                            value={
                                                form.email
                                            }
                                            readOnly
                                            disabled
                                        />

                                        <div className="form-hint">
                                            Email cannot be changed.
                                        </div>

                                    </div>


                                    {/* Address */}

                                    <div className="mb-3">

                                        <label className="form-label">
                                            Address
                                        </label>

                                        <textarea
                                            className="form-control"
                                            rows="3"
                                            value={
                                                form.address
                                            }
                                            onChange={(e) =>
                                                handleChange(
                                                    "address",
                                                    e.target.value
                                                )
                                            }
                                            placeholder="Address"
                                            disabled={saving}
                                        />

                                    </div>

                                </div>


                                {/* Footer */}

                                <div className="modal-footer">

                                    <button
                                        type="button"
                                        className="btn btn-link"
                                        onClick={
                                            handleCloseEdit
                                        }
                                        disabled={saving}
                                    >
                                        Cancel
                                    </button>


                                    <button
                                        type="submit"
                                        className="btn btn-primary"
                                        disabled={saving}
                                    >
                                        {saving ? (
                                            <>
                                                <span
                                                    className="spinner-border spinner-border-sm me-2"
                                                />
                                                Updating...
                                            </>
                                        ) : (
                                            <>
                                                <IconDeviceFloppy
                                                    size={18}
                                                    className="me-2"
                                                />

                                                Update Profile
                                            </>
                                        )}
                                    </button>

                                </div>

                            </form>

                        </div>

                    </div>

                </div>

            )}

        </div>

    );

}