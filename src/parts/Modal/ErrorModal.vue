<template>
    
    <div class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 transition-opacity"></div>
        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center md:items-center md:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all md:my-8 md:w-full md:max-w-lg mb-12">
                <div class="bg-white px-4 pt-5 pb-4 md:p-6 md:pb-4">
                <div class="md:flex md:items-start">
                    <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 md:mx-0 md:h-10 md:w-10">
                    <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 10.5v3.75m-9.303 3.376C1.83 19.126 2.914 21 4.645 21h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 4.88c-.866-1.501-3.032-1.501-3.898 0L2.697 17.626zM12 17.25h.007v.008H12v-.008z" />
                    </svg>
                    </div>
                    <div class="mt-3 text-center md:mt-0 md:ml-4 md:text-left">
                    <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">{{title}}（<router-link class="hover:underline" :to="url">＃{{code}}</router-link>）</h3>
                    <div class="mt-2">
                        <p class="text-md text-gray-500">{{message}}</p>
                    </div>
                    </div>
                </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 md:flex md:flex-row-reverse md:px-6">
                <button @click="$root.modalChange()" type="button" class="inline-flex w-full justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-base font-medium text-white shadow-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 md:ml-3 md:w-auto md:text-md">Deactivate</button>
                </div>
            </div>
            </div>
        </div>
    </div>
</template>

<script>
    module.exports = {
        props:["title", "code", "message", "url"]
    }
</script>