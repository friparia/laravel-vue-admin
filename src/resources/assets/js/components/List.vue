<template lang="pug">
section
  el-col.toolbar(:span="24")
    el-form
      el-form-item
        template(v-for="action in singleActions")
          el-button(type="primary", @click="handleSingle(action)") {{ action.description }}
  template
    el-table(:data="data")
      template(v-for="field in listFields")
        el-table-column(:label="field.description")
          template(scope="scope")
            span {{ scope.row | fieldValue(field) }}
      el-table-column(inline-template, :context="_self", label="操作", width="150", v-if="eachActions")
        span
          el-button(v-for="action in eachActions", @click="handleEach(action, row)") {{ action.description }}
  el-col.toolbar(:span="24", style="padding-bottom:10px;")
  //el-dialog(:title="formTitle", v-model="formVisible")
    //el-form(:model="form", label-width="80px", :rules="formRules", ref="form")
      //template(v-for="fields in formFields")
        //el-form-item(:label="field.description", :prop="field.name")
      

</template>

<script>
export default {
  name: 'List',
  data() {
    return {
      data: [],
      actions: [],
      name: this.$route.name,
      listFields: [],
      formFields: [],
      singleActions: [],
      eachActions: [],
    };
  },
  created() {
    this.$http.get('/api/' + this.name + '/configuration').then((res) => {
      let singleActions = [];
      let eachActions = [];
      res.body.actions.forEach((action) => {
        if(action.is_single){
          singleActions.push(action);
        }
        if(action.is_each){
          eachActions.push(action);
        }
      });
      this.listFields = res.body.listFields;
      this.singleActions = singleActions;
      this.eachActions = eachActions;
    });
    this.$http.get('/api/' + this.name).then((res) => {
      this.data = res.body.data.data
    });
  },
  filters: {
    fieldValue(row, field){
      if(field.type == 'enum'){
        return field.values[row[field.name]];
      }
      return row[field.name];
    },
  },
  methods: {
    handleEach(action, obj){
      if(action.type == 'url'){
      }
      console.log(action);
      console.log(obj);
    },
    handleSingle(action){
      if(action.type == 'url'){
        this.$router.push('/' + this.name + '/' + action.name);
      }
    },
  },
};
</script>
 
