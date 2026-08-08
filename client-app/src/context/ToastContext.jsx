import {
    createContext,
    useContext,
    useState
} from "react";


const ToastContext = createContext();


export function ToastProvider({children}){


    const [toast,setToast] = useState(null);



    const showToast=(message,type="success")=>{

        setToast({
            message,
            type
        });


        setTimeout(()=>{

            setToast(null);

        },3000);

    };



    return (

        <ToastContext.Provider
            value={{
                showToast
            }}
        >

            {children}


            {
                toast &&

                <div
                    className="
                    position-fixed
                    top-0
                    end-0
                    p-3
                    "
                    style={{
                        zIndex:9999
                    }}
                >

                    <div
                        className={
                            `alert alert-${toast.type}`
                        }
                    >

                        {toast.message}

                    </div>


                </div>

            }


        </ToastContext.Provider>

    );

}



export function useToast(){

    return useContext(ToastContext);

}