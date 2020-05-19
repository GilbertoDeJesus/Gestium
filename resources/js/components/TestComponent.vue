    <template>
    <v-app>
        <div>
            <p>
                Test Component Rendered
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

    },
    created () {
        console.log('Component created')
    }
  }
</script>

