<template>
    <div>
        <!--Header-->
        <mHeader></mHeader>
        <!--Header-->

        <!--sidebar-->
        <sidebar></sidebar>
        <!--sidebar-->

        <!--footer-->
        <mfooter></mfooter>
        <!--footer-->
    </div>
</template>


<script>
    import mHeader from './components/header/HeaderComponent';
    import sidebar from './components/sidebar/SideBarComponent';
    import mfooter from './components/footer/FooterComponent';

    export default {
        components: {mHeader , sidebar , mfooter},
        name: "App",
    }
</script>

<style scoped>

</style>
