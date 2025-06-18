<script setup lang="ts">
import { usePage } from '@inertiajs/vue3'
import { useWindowSize } from '@vueuse/core'
import { computed } from 'vue'

import IconBlock from '@/Components/Admin/Icon/IconBlock.vue'
import IconClose from '@/Components/Admin/Icon/IconClose.vue'
import IconCollection from '@/Components/Admin/Icon/IconCollection.vue'
import IconDashboard from '@/Components/Admin/Icon/IconDashboard.vue'
import IconLogout from '@/Components/Admin/Icon/IconLogout.vue'
import IconMedia from '@/Components/Admin/Icon/IconMedia.vue'
import IconMenu from '@/Components/Admin/Icon/IconMenu.vue'
import IconPage from '@/Components/Admin/Icon/IconPage.vue'
import IconSettings from '@/Components/Admin/Icon/IconSettings.vue'
import IconUsers from '@/Components/Admin/Icon/IconUsers.vue'
import NavigationGroup from '@/Components/Admin/Navigation/NavigationGroup.vue'
import NavigationItem from '@/Components/Admin/Navigation/NavigationItem.vue'
import Can from '@/Components/Admin/Permission/Can.vue'
import CollapseButton from '@/Components/Admin/Ui/CollpaseButton.vue'
import { useSidebarStore } from '@/stores/sidebar'
import { CPageProps } from '@/types/page-props'

import IconPlus from '../Icon/IconPlus.vue'
import IconSquareArrowRight from '../Icon/IconSquareArrowRight.vue'

const sidebar = useSidebarStore()
const page = usePage<CPageProps>()
const { width } = useWindowSize()

const user = computed(() => page.props.auth.user)
</script>

<template>
  <aside
    class="sidebar z-10 fixed w-68 flex flex-col gap-7 bg-secondary-950 text-accent-50 rounded-r-lg px-6 py-7 top-0 bottom-0 h-dvh transition"
    :class="sidebar.classes"
  >
    <h2 class="sr-only">Side navigation</h2>
    <div class="flex items-center gap-2">
      <img src="/images/alveo-logo.svg" alt="Logo" class="" />
      <!-- <div class="w-8 h-8 bg-accent-300 rounded-md"></div> -->
      <!-- <h2 class="text-xl ">Site Name</h2> -->
      <button v-if="width < 768" @click="sidebar.toggle" class="ml-auto cursor-pointer">
        <span class="sr-only">Close</span>
        <IconClose />
      </button>
    </div>
    <nav class="w-full h-full overflow-auto no-scrollbar flex flex-col gap-6">
      <h3 class="sr-only">Navigation</h3>
      <a class="flex items-center gap-3 hover:underline" target="_blank" href="/">
        Go to website
        <IconSquareArrowRight />
      </a>

      <NavigationGroup title="Main Navigation">
        <li>
          <NavigationItem :href="route('admin.dashboard')">
            <IconDashboard />
            <span>Dashboard</span>
          </NavigationItem>
        </li>
        <Can permission="show medias">
          <li>
            <NavigationItem :href="route('admin.media.index')">
              <IconMedia />
              <span>Medias</span>
            </NavigationItem>
          </li>
        </Can>
        <Can permission="show menus">
          <li>
            <NavigationItem :href="route('admin.menu.index')">
              <IconMenu />
              <span>Menus</span>
            </NavigationItem>
          </li>
        </Can>
        <Can permission="show users">
          <li>
            <NavigationItem :href="route('admin.user.index')">
              <IconUsers />
              <span>Users</span>
            </NavigationItem>
          </li>
        </Can>
      </NavigationGroup>

      <NavigationGroup title="Content">
        <Can permission="show pages">
          <li>
            <NavigationItem :href="route('admin.page.index')">
              <IconPage />
              <span>Pages</span>
            </NavigationItem>
          </li>
        </Can>
        <Can permission="show collections">
          <li>
            <CollapseButton label="Collections" has-create>
              <template #icon>
                <IconCollection />
              </template>

              <template #items>
                <li v-for="collectionType in page.props.navigation.collectionTypes">
                  <NavigationItem
                    :href="route('admin.collection-type.show', collectionType.type)"
                    class="small"
                  >
                    {{ collectionType.name }}
                  </NavigationItem>
                </li>
              </template>
            </CollapseButton>
          </li>

          <li class="mt-3">
            <Can permission="create collections">
              <Action
                tag="Link"
                variant="secondary"
                class="w-full"
                size="small"
                :href="route('admin.collection-type.create')"
              >
                <IconPlus />
                Create Collection
              </Action>
            </Can>
          </li>
        </Can>

        <Can permission="show blocks">
          <li>
            <CollapseButton label="Blocks" has-create>
              <template #icon>
                <IconBlock />
              </template>

              <template #items>
                <li v-for="blockType in page.props.navigation.blockTypes">
                  <NavigationItem
                    :href="route('admin.block-type.show', blockType.type)"
                    class="small"
                  >
                    {{ blockType.name }}
                  </NavigationItem>
                </li>
              </template>
            </CollapseButton>
          </li>

          <li class="mt-3">
            <Can permission="create blocks">
              <Action
                tag="Link"
                variant="secondary"
                class="w-full"
                size="small"
                :href="route('admin.block-type.create')"
              >
                <IconPlus />
                Create Block
              </Action>
            </Can>
          </li>
        </Can>
      </NavigationGroup>

      <NavigationGroup title="System">
        <li>
          <NavigationItem :href="route('admin.setting.index')">
            <IconSettings />
            <span>Settings</span>
          </NavigationItem>
        </li>
      </NavigationGroup>
    </nav>

    <div class="flex gap-2.5 items-center justify-between">
      <div class="flex flex-col">
        <span class="font-medium">{{ user.name }}</span>
        <span class="text-sm">{{ user.email }}</span>
      </div>
      <Action tag="Link" variant="primary icon" :href="route('logout')" method="post">
        <span class="sr-only">Logout</span>
        <IconLogout />
      </Action>
    </div>
  </aside>
</template>

<style lang="scss" scoped></style>
