<style lang="less">
    @import "./../home.less";
</style>

<template>
   <span>
        <span>{{ item.depart }}</span>
        <!--<Button v-permission="['data-depart-move']" class="small_right" size="small" type="ghost" @click.stop="depart_down(item.id)">下移</Button>-->
        <!--<Button v-permission="['data-depart-move']" class="small_right" size="small" type="ghost" @click.stop="depart_top(item.id)">上移</Button>-->
        <Button v-permission="['data-depart-delete']"  class="small_right" size="small" type="ghost" @click.stop>
            <Poptip
                    confirm
                    title="您确认删除此部门吗？"
                    :transfer='true'
                    @on-ok="depart_delete(item.id)">
                删除
            </Poptip>
        </Button>
        <Button v-permission="['data-depart-new']"  class="small_right" size="small" type="ghost" @click.stop="depart_child(item.id)">+下一级</Button>
        <Button v-permission="['data-depart-rename']" class="small_right" size="small" type="ghost" @click.stop="depart_rename(item.id)">重命名</Button>
    </span>
</template>

<script>
    export default {
        data () {
            return {
                formData :{
                    depart: '',
                },
                depart_id: 0,
            };
        },
        props: {
            item:{}
        },

        methods: {
            depart_top (id) {
                this.$emit('depart_top', id)
            },
            depart_down (id) {
                this.$emit('depart_down', id)
            },
            depart_delete (id) {
                this.$emit('depart_delete', id)
            },
            depart_child (id) {
                this.$emit('depart_child', id)
            },
            depart_rename (id) {
                this.$emit('depart_rename', id)
            },
        },
        watch: {
            // depart () {
            //     this.item = this.depart
            // }
        }
    };
</script>
