<template>
    <div class="w-full flex justify-center py-10">
        <a-tabs v-model:activeKey="aboutKey" class="w-3/4 ">
            <a-tab-pane key="1" tab="ABOUT">
            </a-tab-pane>
            <a-tab-pane key="2" tab="DOCUMENTS">
            </a-tab-pane>
            <a-tab-pane key="3" tab="ORGANIZATION STRUCTURE">
                <a-tabs v-model:activeKey="projectKey" centered tab-position="bottom">
                    <a-tab-pane key="1" tab="PROJECT 1">NOT YET AVAILABLE</a-tab-pane>
                    <a-tab-pane key="2" tab="PROJECT 2" force-render>NOT YET AVAILABLE</a-tab-pane>
                </a-tabs>
            </a-tab-pane>
            <a-tab-pane key="4" tab="ACCOMPLISHMENT" force-render>
                
            </a-tab-pane>
        </a-tabs>
    </div>
</template>
<script>
import { defineComponent, ref } from 'vue';
export default defineComponent({
    setup() {
        return {
            aboutKey: ref('1'),
            projectKey: ref('1'),
        };
    },
    created() {
        this.aboutKey = this.$route.params.id
        console.log(this.$route.params.id);
    }
});
</script>