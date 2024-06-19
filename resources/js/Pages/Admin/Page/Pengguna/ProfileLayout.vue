<template>
    <div class="profile-layout">
        <div class="profile-header">
            <img :src="user.image" alt="Foto Profil" class="profile-image" />
            <h2>{{ user.name }}</h2>
            <p>{{ user.email }}</p>
        </div>
        <div class="profile-body">
            <button class="ml-2 px-4 py-2 bg-blue-500 text-white rounded-md">
                Profile
            </button>
            <button class="ml-2 px-4 py-2 bg-blue-500 text-white rounded-md">
                Properti
            </button>
            <button class="ml-2 px-4 py-2 bg-blue-500 text-white rounded-md">
                Lelang
            </button>
            <button class="ml-2 px-4 py-2 bg-blue-500 text-white rounded-md">
                Food
            </button>
            <button class="ml-2 px-4 py-2 bg-blue-500 text-white rounded-md">
                Marchant
            </button>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        user: {
            type: Object,
            required: true,
        },
    },
};
</script>

<style scoped>
.profile-layout {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 20px;
}

.profile-header {
    text-align: center;
}

.profile-image {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    object-fit: cover;
}
</style>
