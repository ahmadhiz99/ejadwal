import ButtonLink from "@/Components/ButtonLink";
import TextInput from "@/Components/TextInput";
import PrimaryButton from "@/Components/PrimaryButton";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, router, usePage } from "@inertiajs/react";
import { ToastContainer, toast } from "react-toastify";
import { useState, useEffect, useRef } from "react";
import { Input } from "postcss";

export default function TableBuilder({ auth }) {
    const data = usePage().props.data;
    const dataTable = usePage().props.data.dataTable;
    const dataResponse = usePage().props.dataResponse;
    const printRef = useRef();
    const [keyword, setKeyword] = useState(""); 

    useEffect(() => {
        if (dataResponse?.code == 200) {
            toast.success(dataResponse.message);
        }
        if (dataResponse?.code == 400) {
            toast.error(dataResponse.message);
        }
    }, []);
    
    const detail = (e, route, id) => {
        e.preventDefault();
        router.visit(`/${route}/${id}`, {
            method: "get",
        });
    };
    const edit = (e, route, id) => {
        e.preventDefault();
        router.visit(`/${route}/${id}`, {
            method: "get",
        });
    };
    const deleteData = (e, route ,id) => {
        e.preventDefault();
        router.visit(`/${route}/${id}`, {
            method: "delete",
            preserveState: true,
            onSuccess: () => {
                toast.success("Berhasil hapus!");
            },
        });
    };

    const handlePrint = () => {
        // window.print();
        const content = printRef.current.innerHTML;
        const printWindow = window.open('', '', 'height=600,width=800');
        printWindow.document.write(`
          <html>
            <head>
              <title>Print</title>
              <style>
                body { font-family: sans-serif; padding: 20px; }
                @media print {
                  .no-print { display: none !important; }
                }
              </style>
            </head>
            <body>
              ${content}
            </body>
          </html>
        `);
        printWindow.document.close();
        printWindow.focus();
        printWindow.print();
        printWindow.close();
      };

    const handleSearch = (e,route) => {
        e.preventDefault();
        // route = 'schedule.search';
        // console.log(keyword, route);
        route = 'schedule-search';
        if (keyword.trim() !== "") {
            router.visit(`/${route}`, {
                method: "get",
                data: { search: keyword },
                preserveState: true,
            });
        } else {
            toast.error("Please enter a search keyword.");
        }
      };

      const handleChange = (e) =>{
       setKeyword(e.target.value);
    }

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                    Mata Kuliah
                </h2>
            }
        >
            <Head title="Subject" />

            {/* <ToastContainer
                position="top-right"
                autoClose={5000}
                hideProgressBar={'false'}
                newestOnTop={'false'}
                closeOnClick
                rtl={'false'}
                pauseOnFocusLoss
                draggable
                pauseOnHover
                theme="light"
                transition={'true'}
            /> */}

            <ToastContainer />

            <div className="py-8" ref={printRef}>
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4">
                        <div className="p-6 text-gray-900">
                            <div className="page-head flex flex-row justify-between items-center">
                                <h1 className="text-xl font-bold">
                                    {dataTable.tableConfig.title? dataTable.tableConfig.title : null}
                                </h1>
                                {dataTable.tableConfig.action.feature  ? dataTable.tableConfig.action.feature.map((data_feature,idx)=>{
                                    if (data_feature.feature == 'add'){
                                        return(
                                            <ButtonLink href={data_feature.route}>
                                                {data_feature.alias}
                                            </ButtonLink>
                                        )
                                    }
                                    if (data_feature.feature == 'print'){
                                        return(
                                            <div className="no-print flex flex-row items-center gap-2">
                                                <div className="gap-2 flex flex-row items-center">
                                                    <TextInput
                                                        className="required"
                                                        type="text"
                                                        placeholder="Masukan Keyword"
                                                        onChange={(e)=>handleChange(e)}
                                                        // type={form_data.dataType}
                                                        // value={formData[form_data.state]}
                                                        // onChange={(e)=>handleChange(e,form_data.state)}
                                                    />
                                                    <button onClick={(e)=>handleSearch(e,data_feature.route)} className="no-print bg-blue-500 text-white px-4 py-2 rounded">
                                                        {/* {data_feature.alias} */}
                                                        Search
                                                    </button>
                                                </div>

                                                <button onClick={handlePrint} className=" bg-purple-500 text-white px-4 py-2 rounded">
                                                    {data_feature.alias}
                                                </button>
                                            </div>
                                        )
                                    }
                                    if (data_feature.feature == 'print'){
                                        return(
                                            <div className="no-print flex flex-row items-center gap-2">
                                                <div className="gap-2 flex flex-row items-center">
                                                    <TextInput
                                                        className="required"
                                                        type="text"
                                                        placeholder="Masukan Keyword"
                                                        onChange={(e)=>handleChange(e)}
                                                        // type={form_data.dataType}
                                                        // value={formData[form_data.state]}
                                                        // onChange={(e)=>handleChange(e,form_data.state)}
                                                    />
                                                    <button onClick={(e)=>handleSearch(e,data_feature.route)} className="no-print bg-blue-500 text-white px-4 py-2 rounded">
                                                        {/* {data_feature.alias} */}
                                                        Search
                                                    </button>
                                                </div>

                                                <button onClick={handlePrint} className=" bg-purple-500 text-white px-4 py-2 rounded">
                                                    {data_feature.alias}
                                                </button>
                                            </div>
                                        )
                                    }
                                })
                                :
                                null
                                }

                            </div>
                        </div>
                    </div>
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900">
                            <div className="content">
                                <table className="w-full">
                                    <thead className="bg-sky-800 text-white">
                                        <tr>
                                            {dataTable.tableConfig.idType?
                                                (
                                                <th className="py-3 px-8 w-5 text-center">
                                                    {dataTable.tableConfig.idType.alias}
                                                </th>
                                                )
                                                :
                                                null
                                            }
                                            {dataTable.data ? dataTable.data.map((data_table,idx)=>{
                                                    return (
                                                    <th className="py-3 px-8 w-5 text-center">
                                                        {data_table.alias}
                                                    </th>
                                                    )
                                                })
                                                :
                                                null
                                            }
                                            {dataTable.tableConfig.action?
                                                (
                                                <th className="py-3 px-8 w-5 text-center">
                                                    {dataTable.tableConfig.action.alias}
                                                </th>
                                                )
                                                :
                                                null
                                            }
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {data.data
                                            ? data.data.map((data_table, idx) => {
                                                  return (
                                                      <tr
                                                          key={data_table.id}
                                                          className="border text-gray-700"
                                                      >
                                                        {dataTable.tableConfig.idType?
                                                                (
                                                                <td className="px-8 py-8 text-center">
                                                                    {idx + 1}
                                                                </td>
                                                                )
                                                                :
                                                                null
                                                            }
                                                          

                                                        {dataTable.data?dataTable.data.map((data_column_table,idx)=>{
                                                        return (
                                                            <td className="text-center">
                                                              {data_table[data_column_table.column]}
                                                             </td>
                                                            )
                                                        })
                                                        :
                                                          null
                                                        }
                                                   
                                                        {/* Action */}
                                                        {dataTable.tableConfig.action?
                                                        (
                                                            <td>
                                                                <div className="flex flex-row items-center justify-center gap-2">
                                                                {dataTable.tableConfig.action.feature ? dataTable.tableConfig.action.feature.map((data_feature,idx)=>{
                                                                    if( data_feature.feature === 'detail' ){
                                                                        return (
                                                                                <i
                                                                                    onClick={(
                                                                                        e
                                                                                    ) =>
                                                                                        detail(
                                                                                            e,
                                                                                            data_feature.route,
                                                                                            data_table.id,
                                                                                        )
                                                                                    }
                                                                                    className={`bx bx-fw ${data_feature.icon} `}
                                                                                ></i>
                                                                        )
                                                                            
                                                                    }else if( data_feature.feature == 'edit' ){
                                                                            return(
                                                                            <i
                                                                                onClick={(
                                                                                    e
                                                                                ) =>
                                                                                    edit(
                                                                                        e,
                                                                                        data_feature.route,
                                                                                        data_table.id
                                                                                    )
                                                                                }
                                                                                className={`bx bx-fw ${data_feature.icon} text-rose-500`}
                                                                            ></i>
                                                                            )
                                                                    }else if( data_feature.feature == 'delete' ){
                                                                        return(
                                                                        <i
                                                                            onClick={(
                                                                                e
                                                                            ) =>
                                                                                deleteData(
                                                                                    e,
                                                                                    data_feature.route,
                                                                                    data_table.id
                                                                                )
                                                                            }
                                                                            className={`bx bx-fw ${data_feature.icon} text-rose-500`}
                                                                        ></i>
                                                                        )
                                                                }else{
                                                                        null
                                                                    }
                                                                            
                                                                    })
                                                                    :
                                                                    null
                                                                }
                                                            
                                                                </div>
                                                          </td>
                                                        )
                                                        :
                                                        null
                                                        }
                                                             
                                                      </tr>
                                                  );
                                              })
                                            : ""}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
