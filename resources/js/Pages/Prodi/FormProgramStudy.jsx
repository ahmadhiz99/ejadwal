import InputLabel from "@/Components/InputLabel";
import PrimaryButton from "@/Components/PrimaryButton";
import SecondaryButton from "@/Components/SecondaryButton";
import SecondaryButtonLink from "@/Components/SecondaryButtonLink";
import TextInput from "@/Components/TextInput";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, router, usePage } from "@inertiajs/react";
import { useState } from "react";

export default function FormProgramStudy({ auth }) {
    const data = usePage().props.data?.original.data;
    const [prodiName, setProdiName] = useState(data ? data.prodi_name : "");
    const [description, setDescription] = useState(
        data ? data.description : ""
    );
    const handleSubmit = (e, id) => {
        e.preventDefault();
        router.visit(`/programstudies-${data ? `update/${id}` : "store"}`, {
            method: data ? "put" : "post",
            data: {
                prodi_name: prodiName,
                description: description,
            },
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
                                    {data
                                        ? `Detail ${data.prodi_name}`
                                        : "Tambah Baru Program Studi"}
                                </h1>
                            </div>
                        </div>
                    </div>
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900">
                            <div className="content">
                                <div className="flex flex-col gap-5 w-1/2">
                                    <div className="flex flex-col gap-2">
                                        <InputLabel
                                            className="text-sm"
                                            htmlFor="prodiName"
                                            value={
                                                <p>
                                                    <span className="text-rose-500 text-xs">
                                                        *
                                                    </span>{" "}
                                                    Nama Program Studi
                                                </p>
                                            }
                                        />
                                        <TextInput
                                            value={prodiName}
                                            onChange={(e) =>
                                                setProdiName(e.target.value)
                                            }
                                        />
                                        {/* <p className="text-xs text-gray-400">
                                            Gunakan nama yang singkat namun
                                            informatif
                                        </p> */}
                                    </div>

                                    <div className="flex flex-col gap-2">
                                        <InputLabel
                                            className="text-sm"
                                            htmlFor="description"
                                            value="Deskripsi"
                                        />
                                        <textarea
                                            className="border-gray-300 focus:border-sky-500 focus:ring-sky-500 rounded-md shadow-sm"
                                            name=""
                                            id=""
                                            cols="30"
                                            rows="5"
                                            value={description}
                                            onChange={(e) =>
                                                setDescription(e.target.value)
                                            }
                                        ></textarea>
                                        {/* <p className="text-xs text-gray-400">
                                            Gunakan nama yang singkat namun
                                            informatif
                                        </p> */}
                                    </div>

                                    <div className="flex flex-row gap-2">
                                        <SecondaryButtonLink
                                            href="programstudies.index"
                                            className="flex flex-row items-center"
                                        >
                                            <p className="text-xs">Batal</p>
                                        </SecondaryButtonLink>
                                        <PrimaryButton
                                            onClick={(e) =>
                                                handleSubmit(e, data?.id)
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
