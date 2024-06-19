<template>
    <div class="bg-white border-b border-neutral-200">
        <div class="flex px-4 mx-auto divide-x max-w-7xl sm:px-6 lg:px-8">
            <select id="tipe_iklan" name="tipe_iklan"
                class="flex-shrink-0 h-full py-4 border-0 border-l border-neutral-200 text-neutral-500 focus:ring-0 focus:ring-transparent">
                <option value="rumah">Rumah</option>
                <option value="apartemen">Apartemen</option>l
                <option value="tanah">Tanah</option>
            </select>
            <select id="jenis_iklan" name="jenis_iklan"
                class="flex-shrink-0 h-full py-4 border-0 border-neutral-200 text-neutral-500 focus:ring-0 focus:ring-transparent">
                <option value="jual">Jual</option>
                <option value="sewa">Sewa</option>
                <option value="lelang">Lelang</option>
            </select>
            <div class="flex-1">
                <label for="q" class="sr-only">Cari berdasarkan daerah, kota, atau alamat</label>
                <input type="text" name="q" id="q"
                    class="block pl-4 w-full h-full border-0 py-1.5 placeholder:text-neutral-400 focus:ring-0 sm:leading-6"
                    placeholder="Cari berdasarkan daerah, kota, atau alamat" />
            </div>
        </div>
    </div>
</template>
