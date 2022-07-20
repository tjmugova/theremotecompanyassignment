<template>
    <div class="flex justify-between">
        <h4>Resources</h4>
        <button type="button" @click="showForm=true;creating=true"
                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150 disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none">
            Add New
        </button>
    </div>

    <div v-if="showForm">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4 mt-4">
            <form @submit.prevent="submit">
                <div class="grid grid-cols-1 gap-2">
                    <div class="">
                        <label class="block font-medium text-sm text-gray-700">
                            <span>Resource Type</span>
                        </label>
                        <select v-model="resource.resource_type"
                                class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm w-full disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none">
                            <option value="pdf">pdf</option>
                            <option value="html">html</option>
                            <option value="link">link</option>
                        </select>
                        <p class="text-sm text-red-600 mt-2" v-show="resource.errors.resource_type">
                            {{ resource.errors.resource_type }}
                        </p>
                    </div>
                    <div class="">
                        <label class="block font-medium text-sm text-gray-700" for="title">
                            <span>Title</span>
                        </label>
                        <input id="title"
                               class="mt-1 block w-full h-9 border border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none"
                               v-model="resource.title" required ref="title">
                        <p class="text-sm text-red-600 mt-2" v-show="resource.errors.title">
                            {{ resource.errors.title }}
                        </p>
                    </div>
                    <div v-if="resource.resource_type==='pdf'">
                        <label class="block font-medium text-sm text-gray-700" for="file">
                            <span>File</span>
                        </label>
                        <input id="file" type="file" @change="onFileChange($event)"
                               class="mt-1 block w-full border border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none"
                               required ref="file">
                        <p class="text-sm text-red-600 mt-2" v-show="resource.errors.file">
                            {{ resource.errors.file }}
                        </p>
                    </div>
                    <div v-if="resource.resource_type==='html'">
                        <div>
                            <label class="block font-medium text-sm text-gray-700" for="description">
                                <span>Description</span>
                            </label>
                            <textarea id="description" ref="description" rows="3"
                                      class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none"
                                      v-model="resource.description"/>
                            <p class="text-sm text-red-600 mt-2" v-show="resource.errors.description">
                                {{ resource.errors.description }}
                            </p>
                        </div>
                        <div class="mt-4">
                            <label class="block font-medium text-sm text-gray-700" for="description">
                                <span>HTML</span>
                            </label>
                            <textarea id="html" ref="html" rows="3"
                                      class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none"
                                      v-model="resource.html"/>
                            <p class="text-sm text-red-600 mt-2" v-show="resource.errors.html">
                                {{ resource.errors.html }}
                            </p>
                        </div>
                    </div>
                    <div v-if="resource.resource_type==='link'">
                        <div>
                            <label class="block font-medium text-sm text-gray-700" for="link">
                                <span>Link</span>
                            </label>
                            <input id="link"
                                   class="mt-1 border  h-9   block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none"
                                   v-model="resource.link" required ref="link">
                            <p class="text-sm text-red-600 mt-2" v-show="resource.errors.link">
                                {{ resource.errors.link }}
                            </p>
                        </div>
                        <div class="mt-4">
                            <label class="block font-medium text-sm text-gray-700" for="open_in_new_tab">
                                <div class="flex items-center">
                                    <input type="checkbox" v-model="resource.open_in_new_tab" id="open_in_new_tab"
                                           class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none">
                                    <div class="ml-2">
                                        Open in New Tab
                                    </div>
                                </div>
                            </label>
                            <p class="text-sm text-red-600 mt-2" v-show="resource.errors.open_in_new_tab">
                                {{ resource.errors.open_in_new_tab }}
                            </p>
                        </div>
                    </div>

                </div>
                <div class="flex items-center justify-end mt-4">
                    <button type="button" v-if="creating" @click.prevent="submit"
                            :class="{ 'opacity-25': resource.processing }"
                            :disabled="resource.processing"
                            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150 disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none">
                        Save
                    </button>
                    <button type="button" v-if="editing" @click.prevent="update"
                            :class="{ 'opacity-25': resource.processing }"
                            :disabled="resource.processing"
                            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150 disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4 mt-4">
        <table class="w-full whitespace-no-wrap">
            <thead class="bg-gray-50">
            <tr class="text-left font-bold">
                <th class="px-6 pt-4 pb-4 font-medium text-gray-500">ID</th>
                <th class="px-6 pt-4 pb-4 font-medium text-gray-500">Type</th>
                <th class="px-6 pt-4 pb-4 font-medium text-gray-500">Title</th>
                <th class="px-6 pt-4 pb-4 font-medium text-gray-500">Created At</th>
                <th class="px-6 pt-4 pb-4 font-medium text-gray-500">Action</th>
            </tr>
            </thead>
            <tbody>
            <tr v-if="!resources.length">
                <td colspan="5" class="px-6 py-4 text-center">
                    No resources yet
                </td>
            </tr>
            <tr v-for="(resource,index) in data" :key="resource.id"
                class="hover:bg-gray-100 focus-within:bg-gray-100">
                <td class="border-t">
                  <span class="px-6 py-4 flex items-center">
                        {{ resource.id }}
                    </span>
                </td>
                <td class="border-t">
                    <span class="px-6 py-4 flex items-center"
                          v-if="resource.resource_type==='pdf'">
                        pdf
                    </span>
                    <span class="px-6 py-4 flex items-center"
                          v-if="resource.resource_type==='html'">
                        html
                    </span>
                    <span class="px-6 py-4 flex items-center"
                          v-if="resource.resource_type==='link'">
                        link
                    </span>

                </td>
                <td class="border-t">
                     <span class="px-6 py-4 flex items-center">
                        {{ resource.title }}
                    </span>
                </td>
                <td class="border-t">
                     <span class="px-6 py-4 flex items-center">
                        {{ resource.created_at }}
                    </span>
                </td>
                <td class="border-t pr-2">
                    <div>
                        <button type="button" @click="edit(index)"
                                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150 disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none">
                            Edit
                        </button>
                        <button type="button" @click="confirmDelete(index)"
                                class="ml-2 inline-flex items-center px-4 py-2 bg-red-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150 disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none">
                            Delete
                        </button>

                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    name: "AdminPage",
    props: {
        resources: Object,
    },
    data() {
        return {
            data: [],
            resource: {
                id: '',
                resource_type: '',
                title: '',
                description: '',
                html: '',
                link: '',
                file: '',
                open_in_new_tab: false,
                processing: false,
                errors: {},
            },
            showForm: false,
            creating: false,
            editing: false,
        }
    },
    methods: {
        onFileChange(e) {
            this.resource.file = e.target.files[0]
        },
        submit() {
            this.resource.processing = true;
            const formData = new FormData();
            formData.append("resource_type", this.resource.resource_type);
            formData.append("title", this.resource.title);
            formData.append("file", this.resource.file);
            formData.append("description", this.resource.description);
            formData.append("html", this.resource.html);
            formData.append("link", this.resource.link);
            formData.append("open_in_new_tab", this.resource.open_in_new_tab);
            axios
                .post("/admin/resource/store", formData, {})
                .then((response) => {
                    alert('Created successfully');
                    //push the recently created record
                    this.data.unshift(response.data)
                    this.showForm = false;
                    this.creating = false;
                    //reset form
                    this.resource.resource_type = '';
                    this.resource.title = '';
                    this.resource.description = '';
                    this.resource.html = '';
                    this.resource.link = '';
                    this.resource.file = '';
                    this.resource.open_in_new_tab = false;
                    this.resource.errors = {};
                    this.resource.processing = false;
                })
                .catch((error) => {
                    this.resource.errors = {};
                    if (error.response && error.response.data.errors) {
                        for (const key in error.response.data.errors) {
                            this.resource.errors[key] = error.response.data.errors[key][0];
                        }
                    } else {
                        alert('An error occurred')
                    }
                    this.resource.processing = false;
                });
        },
        confirmDelete(index) {
            let resource = this.data[index];
            if (confirm("Are you sure you want to delete") === true) {
                axios
                    .delete("/admin/resource/" + resource.id + '/destroy')
                    .then((response) => {
                        this.data.splice(index, 1)
                        alert('Deleted successfully');
                    })
                    .catch((error) => {
                        alert('An error occurred')
                    });
            }
        },
        edit(index) {
            let resource = this.data[index];
            this.resource.id = resource.id;
            this.resource.resource_type = resource.resource_type;
            this.resource.title = resource.title;
            this.resource.description = resource.description;
            this.resource.html = resource.html;
            this.resource.link = resource.link;
            this.resource.open_in_new_tab = resource.open_in_new_tab;
            this.showForm = true;
            this.editing = true;

        },
        update() {
            this.resource.processing = true;
            const formData = new FormData();
            formData.append("_method", 'PUT');
            formData.append("resource_type", this.resource.resource_type);
            formData.append("title", this.resource.title);
            formData.append("file", this.resource.file);
            formData.append("description", this.resource.description);
            formData.append("html", this.resource.html);
            formData.append("link", this.resource.link);
            formData.append("open_in_new_tab", this.resource.open_in_new_tab);
            axios
                .post("/admin/resource/" + this.resource.id + '/update', formData, {})
                .then((response) => {
                    alert('Update successfully');
                    //update the recently created record
                    this.data.forEach((item,index) => {
                        if (item.id === this.resource.id) {
                            this.data[index] = response.data;
                        }
                    })
                    this.showForm = false;
                    this.editing = false;
                    //reset form
                    this.resource.resource_type = '';
                    this.resource.title = '';
                    this.resource.description = '';
                    this.resource.html = '';
                    this.resource.link = '';
                    this.resource.file = '';
                    this.resource.open_in_new_tab = false;
                    this.resource.errors = {};
                    this.resource.processing = false;
                })
                .catch((error) => {
                    this.resource.errors = {};
                    if (error.response && error.response.data.errors) {
                        for (const key in error.response.data.errors) {
                            this.resource.errors[key] = error.response.data.errors[key][0];
                        }
                    } else {
                        alert('An error occurred')
                    }
                    this.resource.processing = false;
                });
        },
    },
    mounted() {
        //since props are immutable lets create data variable
        this.data = this.resources;

    }
}
</script>

<style scoped>

</style>
