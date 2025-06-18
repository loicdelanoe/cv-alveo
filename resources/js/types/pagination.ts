export interface PaginateCollection<T> {
  data: T[]
  links: {
    url: string | null
    label: string
    active: boolean
  }[]
}
