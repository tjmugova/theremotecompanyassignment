<template>
    <h4>Resources</h4>
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4 mt-4" v-for="(resource,index) in resources"
         :key="index">

        <div v-if="resource.resource_type==='pdf'">
            <a :href="'/storage/'+resource.file_path"
               class="text-decorate text-underline" title="Click to download pdf">{{ resource.title }}<span
                class="text-sm ml-2">(pdf)</span></a>
        </div>
        <div v-if="resource.resource_type==='link'">
            <a :href="resource.link" :target="resource.open_in_new_tab?'blank':''"
               class="text-decorate text-underline" :title="resource.title">{{ resource.title }} <span
                class="text-sm ml-2">(link)</span></a>
        </div>
        <div v-if="resource.resource_type==='html'">
            <h3>{{ resource.title }} <span class="text-sm ml-2">(html)</span></h3>
            <div class="text-sm">{{resource.description}}</div>
            <div v-html="resource.html"></div>
            <button
                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150 disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none"
                @click="copy(resource.html)">Copy to Clipboard
            </button>
        </div>
    </div>
</template>

<script>
export default {
    name: "ResourcesList",
    props: {
        resources: Object,
    },
    methods: {
        copy(text) {
            navigator.clipboard.writeText(text).then(() => {
                alert('Copied to clipboard')
            })
        }
    }
}
</script>

<style scoped>

</style>
