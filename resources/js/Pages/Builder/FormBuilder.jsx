import InputLabel from "@/Components/InputLabel";
import PrimaryButton from "@/Components/PrimaryButton";
import SecondaryButton from "@/Components/SecondaryButton";
import SecondaryButtonLink from "@/Components/SecondaryButtonLink";
import TextInput from "@/Components/TextInput";
import Dropdown from "@/Components/Dropdown";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, router, usePage } from "@inertiajs/react";
import { useState } from "react";

export default function FormBuilder({ auth }) {
    const data = usePage().props.data.data;
    const dataForm = usePage().props.data?.dataForm;
    const [formData, setFormData] = useState(data ? data : "");

    const handleChange = (e,key) =>{
        setFormData(prevState =>({
            ...prevState,
            [key]:e.target.value
        }))
    }
    const handleSubmit = (e, id, route, method) => {
        e.preventDefault();
        router.visit(`${data ? `${route}/${id}` : route}`, {
            method: data ? 'put' : 'post',
            data: formData,
        });
    };
    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                    Tambah Baru
                </h2>
            }
        >
            <Head title="Tambah Baru" />

            <div className="py-8">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4">
                        <div className="p-6 text-gray-900">
                            <div className="page-head flex flex-row items-center">
                                <h1 className="text-xl font-bold">
                                    {
                                        dataForm.formConfig?.title
                                    }
                                </h1>
                            </div>
                        </div>
                    </div>
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900">
                            <div className="content">
                                <div className="flex flex-col gap-5 w-1/2">
                                        {dataForm.formConfig.formInput?dataForm.formConfig.formInput.map((form_data,idx)=>{
                                            if(form_data.inputType == 'TextInput'){
                                                return (
                                                    <div className="flex flex-col gap-2">
                                                        <InputLabel
                                                            className="text-sm"
                                                            htmlFor="menuName"
                                                            value={
                                                                <p>
                                                                    {form_data.required == 'true'?
                                                                    (<span className="text-rose-500 text-xs">
                                                                        * {" "}
                                                                    </span>)
                                                                    :null
                                                                    }
                                                                   {form_data.alias}
                                                                </p>
                                                            }
                                                        />
                                                        <TextInput
                                                            className="required"
                                                            type={form_data.dataType}
                                                            value={formData[form_data.state]}
                                                            onChange={(e)=>handleChange(e,form_data.state)}
                                                        />
                                                        {form_data.note || form_data.note != '' ? 
                                                            (
                                                                <p className="text-xs text-gray-400">
                                                                   {form_data.note}
                                                                </p>
                                                            )
                                                            :
                                                            null
                                                         }
                                                    </div>

                                                )
                                            }

                                            // Text Area
                                            if(form_data.inputType == 'textarea'){
                                                return (
                                                    <div className="flex flex-col gap-2">
                                                        <InputLabel
                                                            className="text-sm"
                                                            htmlFor="description"
                                                            value={form_data.alias}
                                                        />
                                                        <textarea
                                                            className="border-gray-300 focus:border-sky-500 focus:ring-sky-500 rounded-md shadow-sm"
                                                            name=""
                                                            id=""
                                                            cols="30"
                                                            rows="5"
                                                            value={formData[form_data.state]}
                                                            onChange={(e)=>handleChange(e,form_data.state)}
                                                        ></textarea>

                                                        {form_data.note || form_data.note != '' ? 
                                                            (
                                                                <p className="text-xs text-gray-400">
                                                                   {form_data.note}
                                                                </p>
                                                            )
                                                            :
                                                            null
                                                         }
                                                    </div>

                                                )
                                            }

                                            // Dropdown
                                            if(form_data.inputType == 'dropdown'){
                                                return (
                                                    <div className="flex flex-col gap-2">
                                                        <InputLabel
                                                            className="text-sm"
                                                            htmlFor="description"
                                                            value={form_data.alias}
                                                        />
                                                        <select
                                                            className="border-gray-300 focus:border-sky-500 focus:ring-sky-500 rounded-md shadow-sm"
                                                            value={formData[form_data.state]}
                                                            onChange={(e)=>handleChange(e,form_data.state)}
                                                            >
                                                                <option className="rounded-md" value={form_data.data.default}>--Choose--</option>
                                                            {
                                                            form_data.data ? form_data.data.data.map((item, idx)=>{
                                                                return (
                                                                    <option className="rounded-md" value={item[form_data.data.id]}>{item[form_data.data.name]}</option>
                                                                )
                                                            })
                                                            :
                                                            null
                                                            }
                                                        </select>

                                                        {form_data.note || form_data.note != '' ? 
                                                            (
                                                                <p className="text-xs text-gray-400">
                                                                   {form_data.note}
                                                                </p>
                                                            )
                                                            :
                                                            null
                                                         }
                                                    </div>

                                                )
                                            }

                                        })
                                        :null
                                        }
                                    
                                    <div className="flex flex-row gap-2">
                                        <SecondaryButtonLink
                                            href="builder.table-builder"
                                            className="flex flex-row items-center"
                                        >
                                            <p className="text-xs">Batal</p>
                                        </SecondaryButtonLink>
                                        <PrimaryButton
                                            onClick={
                                                
                                                (e) =>
                                                handleSubmit(e, data?.id, dataForm.formConfig.route, dataForm.formConfig.method )
                                            }
                                            className="flex flex-row items-center"
                                        >
                                            <p className="text-xs">
                                                {data ? `Update` : "Simpan"}
                                            </p>
                                        </PrimaryButton>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
