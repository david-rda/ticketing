<template>
    <div>
        <router-view></router-view>
    </div>
</template>

<script>
    export default {
        
    }
</script>

<style lang="scss">
    @import "assets/css/variables.scss";

    @font-face {
        font-family: "firago_regular";
        src : url("assets/fonts/FiraGO-Regular.ttf")
    }

    @font-face {
        font-family: "firago_bold";
        src: url("assets/fonts/FiraGO-Bold.ttf");
    }

    html, body {
        margin: 0;
        padding: 0;
        background-color: #fbfbfb !important;
        color: $fgColor;
        overflow-x: hidden;
    }

    .pointer {
        pointer-events: none;
    }

    * {
        box-sizing: border-box !important;
        font-family: "firago_regular" !important;
        font-weight: 600 !important;
    }
</style>