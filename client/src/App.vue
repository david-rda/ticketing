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
        font-family: "neue_regular";
        src : url("assets/fonts/NeueFrutigerGeorgianCAPS-Regular.ttf")
    }

    @font-face {
        font-family: "neue_bold";
        src: url("assets/fonts/NeueFrutigerGeorgianCAPS-Bold.ttf");
    }

    @font-face {
        font-family: "neue_black";
        src: url("assets/fonts/NeueFrutigerGeorgianCAPS-Black.ttf");
    }

    @font-face {
        font-family: "neue_light";
        src: url("assets/fonts/NeueFrutigerGeorgianCAPS-Light.ttf");
    }

    html, body {
        margin: 0;
        padding: 0;
        background-color: $bgColor;
        color: $fgColor;
    }

    * {
        box-sizing: border-box !important;
        //font-family: "neue_bold";
    }
</style>