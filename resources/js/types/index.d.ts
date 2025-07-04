import { Config } from 'ziggy-js'

import { LaravelCollection } from './models/collection'

export interface User extends LaravelCollection {
  name: string
  email: string
  email_verified_at?: string
}

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
  auth: {
    user: User
  }
  ziggy: Config & { location: string }
}
