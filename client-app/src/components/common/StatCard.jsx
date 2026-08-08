export default function StatCard({

title,
value,
icon:Icon,
color="primary"

}){


return (

<div className="card">

<div className="card-body">


<div className="d-flex">


<span
className={`avatar bg-${color}-lt`}
>

<Icon size={24}/>

</span>



<div className="ms-3">

<div className="text-secondary">

{title}

</div>


<div className="h2">

{value}

</div>


</div>


</div>


</div>

</div>


);

}