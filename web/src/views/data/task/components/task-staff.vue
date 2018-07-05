<style lang="less">
    @import './../components/table.less';
</style>

<template>
    <div>
        <Modal
                v-model="show"
                @on-ok="ok('formData')"
                :loading="loading"
                :width="1200"
                :styles="{top: '10px'}">
                <div slot="header" style="color:#f60;text-align:center">
                   <div>项目组织关系表</div>
                    <Button style="float: right;margin-top: -20px;margin-right: 50px" type="success" @click="exportExcel">导出Excel</Button>
                </div>
                <Table ref="table" :columns="dataX" :data="dataY" width="1000px" height="500" border></Table>
                <div slot="footer">
                    <!--<Button type="error" size="large" long :loading="modal_loading" @click="del">Delete</Button>-->
                </div>
        </Modal>

    </div>
</template>

<script>
    export default {
        data () {
            return {

                show : false,
                loading: true,
                dataX:[
                    {
                        title: 'Name',
                        key: 'name'
                    },
                ],
                dataY:[],
            };
        },
        props: {
            staffModel:false,

        },
        created () {

        },

        methods: {
            exportExcel(){
                window.open('api/task/staffs/export')
            },
            getData(){
                this.JAjax.postJson('/task/staffs',{},res=>{
                    this.dataX = [];
                    console.log()
                    Object.values(res.tasks).forEach((t,index)=>{
                        console.log(index)
                        let arrayX= [];
                        if(index === 0 ){
                             arrayX=  {
                                title: t,
                                key: t,
                                width:100,
                                align: 'center',
                                fixed: 'left',
                            }
                        }
                        else if (res.tasks.length -1 === index){
                            arrayX=  {
                                title: t,
                                key: t,
                                width:100,
                                align: 'center',
                                fixed: 'right',
                            }
                        }else{
                             arrayX=  {
                                title: t,
                                key: t,
                                width:120,
                                align: 'center'
                            }
                        }
                        this.$set(this.dataX,index,arrayX)
                    })

                    Object.values(res.data).forEach((t,index)=>{
                        this.$set(this.dataY,index,t)
                    })
                })
            }
        },
        watch: {
            staffModel(){
                this.show = true
                this.getData();
            }
        }
    };
</script>
