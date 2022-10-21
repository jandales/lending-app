<script setup>

const props = defineProps({
     title : {
            type : String,
            default : null,
     }, 
     value : String,    
     options : {
                type : Array,
                default : null,
    },
})


console.log(props.options.value)
const emit  = defineEmits(['click-action'])

const handleclick  = (value) => {
    if (value) {
        emit('click-action', value )
        return;
    }
    emit('click-action');

    
}
</script>
<template>

       <div class="flex space-x-2 justify-center">
                <div class="dropdown relative">
                  <button
                    class="
                      dropdown-toggle
                      btn-light
                    "
                    type="button"
                    id="dropdownMenuButton9"
                    data-bs-toggle="dropdown"
                    aria-expanded="false"
                  >
                   {{title}}
                    <span class="text-black ml-2  transition
                      duration-150
                      ease-in-out">{{ value}}</span>
                    <svg
                      aria-hidden="true"
                      focusable="false"
                      data-prefix="fas"
                      data-icon="caret-down"
                      class="w-2 ml-2"
                      role="img"
                      xmlns="http://www.w3.org/2000/svg"
                      viewBox="0 0 320 512"
                    >
                      <path
                        fill="currentColor"
                        d="M31.3 192h257.3c17.8 0 26.7 21.5 14.1 34.1L174.1 354.8c-7.8 7.8-20.5 7.8-28.3 0L17.2 226.1C4.6 213.5 13.5 192 31.3 192z"
                      ></path>
                    </svg>
                  </button>
                  <ul
                    class="
                      dropdown-menu
                      min-w-max
                      absolute
                      hidden
                      bg-white
                      text-base
                      z-50
                      float-left
                      py-2
                      list-none
                      text-left
                      rounded-lg
                      shadow-lg
                      mt-1                     
                      m-0
                      bg-clip-padding
                      border-none
                      w-full
                    "
                    aria-labelledby="dropdownMenuButton9"
                  >
                    <li  v-for="(option, index) in options" :key="index">
                      <a
                        @click="handleclick(option)"
                        class="
                          dropdown-item
                          text-sm
                          py-2
                          px-4
                          font-normal
                          block
                          w-full
                          whitespace-nowrap
                          bg-transparent
                          text-gray-700
                          hover:bg-gray-100
                        "
                        href="#"
                        >{{option.name}}</a
                      >
                    </li>
                  </ul>
                </div> 
              </div>
</template>