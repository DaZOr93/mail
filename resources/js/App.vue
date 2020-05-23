<template>
    <div class="main-wrap">
        <!--Header-->
        <mHeader></mHeader>
        <!--Header-->
        <div class="main">
            <!--sidebar-->
            <div class="sidebar-wrap">
                <sidebar></sidebar>
            </div>
            <!--sidebar-->

            <div class="content-wrap w100">
                <div class="content-nav" v-if="$route.path !== '/settings'">
                    <contentBar></contentBar>
                </div>
                <router-view></router-view>
            </div>
        </div>

        <!--footer-->
        <mfooter></mfooter>
        <!--footer-->
    </div>
</template>


<script>
    import mHeader from './components/Header/HeaderComponent';
    import sidebar from './components/Sidebar/SideBarComponent';
    import mfooter from './components/Footer/FooterComponent';
    import contentBar from './components/MainContent/Nav/NavBarComponent'

    export default {
        components: {mHeader, sidebar, mfooter, contentBar},
        name: "App",
    }
</script>

<style scoped>
</style>
