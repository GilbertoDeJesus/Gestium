    <template>
    <v-app>
        <div>
            <p>
                Example Component
            </p>
        </div>
    </v-app>
</template>

<script>
  export default {
    data () {
      return {
        search: '',
      }
    },
    methods : {
        async getUser() {
            let response = await axios.get('api/user').catch( error => console.log(error));
            console.log(response.data)
        }
    },
    created () {
        this.getUser()
    }
  }
</script>

