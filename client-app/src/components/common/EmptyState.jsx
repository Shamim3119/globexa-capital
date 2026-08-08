import {
    IconDatabaseOff
} from "@tabler/icons-react";


export default function EmptyState({

    title="No Data Found",

    message="There is nothing to display"

}){


return (

<div className="card">

<div className="card-body text-center">


<IconDatabaseOff
size={48}
className="text-secondary"
/>


<h3 className="mt-3">

{title}

</h3>


<p className="text-secondary">

{message}

</p>


</div>

</div>


);


}