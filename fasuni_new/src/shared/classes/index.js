export class Pagination {
  constructor(pagination = {}) {
    this.current = pagination.current || 1;
    this.total = pagination.total || 0;
    this.perPage = pagination.perPage || 0;
  }
};
