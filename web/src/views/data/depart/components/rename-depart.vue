<style lang="less">

</style>

<template>
    <div>
        <Modal
                v-model="show"
                title="修改部门名称"
                @on-ok="ok"
                @on-cancel="cancel">
            <Form  :label-width="100">
                <FormItem label="部门名称：" prop="depart">
                    <Input v-model="name" type="text" placeholder="请输入部门名称" style="width: 80%"></Input>
                </FormItem>
            </Form>
        </Modal>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                formData :{
                    depart: '',
                },
                show : false,
            };
        },
        props: {
            renameModel: false,
            depart_id: 0,
            name : ''
        },
        methods: {
            ok () {
                this.formData.depart = this.name
                if( this.formData.depart !== '') {
                    this.JAjax.postJson('depart/rename/'+this.depart_id, this.formData, res=>{
                        if ( res.code === 1){
                            this.$Message.success(res.message);
                            this.$emit('afresh_list', 'data')
                        }
                    })
                }
            },
            cancel () {
                // this.$Message.info('Clicked cancel');
            }
        },
        watch: {
            renameModel () {
                this.show = true
            },
            depart_id () {
                this.depart_id = this.depart_id
            }
        }
    };
</script>
