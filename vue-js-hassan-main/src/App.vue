<template>
  <div id="app">
        <div class="container mt-5">
            <div class="row">
                <div class="col-12">
                    <button class="btn btn-primary" v-if="activeButtonCreate" data-toggle="modal" data-target="#modal-create">Create</button>
                    <button class="btn btn-primary ml-2" @click="addListeActive" v-if="activeButtonValidate">Validate</button>
                    <button class="btn btn-primary ml-2" v-if="activeButtonCancel">Cancel</button>

                    <button class="btn btn-primary ml-2" @click="validateDelete" v-if="!validateForDelete">Validate</button>
                    <button class="btn btn-primary ml-2" @click="cancelDelete"   v-if="!activeButtonCancelForDelete">Cancel</button>
                  
                </div>
                <div class="col-12 mt-5">
                    <div class="row">
                        <div class="col-6">
                            <div class="card" style="width: 18rem;">
                                <div class="card-header">
                                    <div class="d-flex justify-content-around">
                                        <div class="p-2">ToDo Active</div>
                                        <div class="p-2">{{listeActive.length}} items</div>
                                    </div>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item" v-for="(item, index) in listeActive"   v-if="item = 'active'">
                                        <div class="d-flex" :class="item.save == true ? 'backgroud-color-griss' : '' " >
                                            <div class="mr-auto p-2">
                                                {{item.title}}
                                                {{item.etat}}
                                            </div>
                                            <div class="p-2" v-if="item.save">
                                                <a href="javascript:void(0)" @click="toListTerminated(index)">
                                                    <i class="fa-solid fa-check"></i>
                                                </a>
                                            </div>
                                            <div class="p-2" v-if="item.save">
                                                <a href="javascript:void(0)" @click="deleteItemsListeActive(index)">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </div>

                                        
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card" style="width: 18rem;">
                                <div class="card-header"> 
                                    <div class="d-flex justify-content-around">
                                        <div class="p-2">ToDo Terminated</div>
                                        <div class="p-2">{{listeTerminate.length}} items</div>
                                    </div>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item" v-for="(item, index) in listeTerminate">
                                        <div class="d-flex backgroud-color-griss" >
                                            <div class="mr-auto p-2">
                                                {{item.title}}
                                            </div>
                                            <div class="p-2 " > 
                                                <a href="javascript:void(0)" @click="deleteItemsListeTerminate(index)">
                                                   
                                                </a>
                                            </div>
                                          
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="modal" id="modal-create" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Modal title</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <form @submit="addToListeActive">
                        <div class="form-group">
                          <label for="title">Title</label>
                          <input type="text" class="form-control" id="title" v-model="form.title" placeholder="title">
                        </div>
                        <div class="form-group">
                          <label for="exampleInputPassword1">Description</label>
                          <textarea row="5"  placeholder="Description" v-model="form.description" class="form-control"></textarea>
                        </div>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="cancelModal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </form>
                </div>
              </div>
            </div>
        </div>
    </div>
</template>


<script>
import axios from 'axios'
export default {
  data() {
    return {
        form:{
            title:'',
            description:'',
        },
      listeActive: [],
      listeTerminate: [],
      activeButtonCreate:true,
      activeButtonValidate :false,
      activeButtonCancel :false,
      validateForDelete:true,
      activeButtonCancelForDelete:true,
      deleteItemsId:-1
    }
  },
  created() {
    this.getAllListeActive();
  },
  methods:{
    addToListeActive(e){
        if(this.form.title == ""){
            alert("merci de remplire title");
            e.preventDefault();
            return null;
        }
        this.listeActive.push({id:0, title: this.form.title, description: this.form.description,save:false });
        this.activeButtonValidate =true;
        this.activeButtonCancel =true;
        e.preventDefault();
        this.cancelModal();
    },
    cancelModal(){
        this.form.title         = "";
        this.form.description   = "";
    },
    toListTerminated(index){
        let id          = this.listeActive[index].id ? this.listeActive[index].id : 0;
        let title       = this.listeActive[index].title
        let description = this.listeActive[index].description
        this.listeTerminate.push({ id:id,title: title, description: description });
        this.listeActive.splice(index,1);
   
        axios.put('/edit.php',{id})
        .then(re => {
            console.log(re)
        })
        .catch(error => {
            console.log(error)
        })

    },
    deleteItemsListeActive(index){
       
        let id = this.listeActive[index].id;
        this.deleteItemsId= id ; 
        this.validateForDelete=!this.validateForDelete,
        this.activeButtonCancelForDelete=!this.activeButtonCancelForDelete
    },
    deleteItemsListeTerminate(index){
        let id = this.listeActive[index].id;
        
        if(id != 0 ){
            this.deleteListeById(id).then(response=>{
                this.getAllListeActive();
            });
        }
    },
    getAllListeActive(){
        this.listeActive= [];
        this.listeTerminate= [];
        axios.get('/liste.php')
        .then(response => {
            let data = response.data;

            data.forEach((value) => {
                if(value.etat === 'terminated') this.listeTerminate.push({ id:value.id,title: value.title,etat: value.etat, description: value.$eventdescription,save : true });
                else this.listeActive.push({ id:value.id,title: value.title,etat: value.etat, description: value.$eventdescription,save : true });
            });
        })
        .catch(error => {
            console.log(error)
        })
    },
    addListeActive(){
        let filter = {save:0};
        let data =  this.listeActive.filter(item => {
            for (let key in filter) {
                if (item[key] != 0)
                return false;
            }
            return true;
        });

        axios.post('/add.php',{todo:JSON.stringify(data)})
        .then(response => {
            this.activeButtonValidate =false;
            this.activeButtonCancel =false;
            this.getAllListeActive();
        })
        .catch(error => {
            console.log(error)
        })
    },


    


    async deleteListeById(idTodo){
        return  await axios.post('/delete.php',{id:idTodo})
        .then(response => {
            return true;
        })
        .catch(error => {
            console.log(error)
        })
    }
    ,

    validateDelete(){

        let id = this.deleteItemsId;
        if(id != 0 ){
            this.deleteListeById(id).then(response=>{
                this.getAllListeActive();
            });
        }
        
        this.validateForDelete=!this.validateForDelete;
        this.activeButtonCancelForDelete=!this.activeButtonCancelForDelete
    }
    ,
    cancelDelete(){
        this.deleteItemsId= -1 ;
        this.validateForDelete=!this.validateForDelete;
        this.activeButtonCancelForDelete=!this.activeButtonCancelForDelete

    }
  }
  
}
</script>
<style>
 .backgroud-color-griss{
    background-color: gray;
 }

</style>
