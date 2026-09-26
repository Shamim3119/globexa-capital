import { Outlet } from "react-router-dom";

export default function ClientLayout(){

return (
<div className="page">

<header className="navbar navbar-expand-md d-print-none">

<div className="container-xl">

<h2 className="navbar-brand">
Globexa Capital Ltd.
</h2>

</div>

</header>


<div className="page-wrapper">

<div className="container-xl">

<Outlet />

</div>

</div>


</div>
)

}