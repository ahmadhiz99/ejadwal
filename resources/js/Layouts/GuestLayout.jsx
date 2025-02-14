import ApplicationLogo from "@/Components/ApplicationLogo";
import { Link } from "@inertiajs/react";
import { useState,useEffect } from "react";

export default function Guest({ children }) {
    const [content, setContent] = useState();

    useEffect(()=>{
        const fetchData = async () =>{
            try{
                const responseContent = await fetch('/content-page');
                const dataContent = await responseContent.json();
                
                const contents = dataContent.reduce((acc, item) => {
                    acc[item.name] = item.value;
                    return acc;
                  }, {});

                setContent(contents);

                console.log(content.title);

            }catch(error){
                console.error('Error Fetching menu data:',error);
            }
        }

        fetchData();
    },[])

    return (
        <div className="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <div className="mb-5">
                <Link href="/">
                    <ApplicationLogo className="w-20 h-20 fill-current text-gray-500" />
                </Link>
            </div>
            <h1 className="text-xl uppercase font-bold">
               {content?.title}
            </h1>
            <div className="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                {children}
            </div>
        </div>
    );
}
