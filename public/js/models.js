const stypes = [
  {
    id: 1,
    code: 1,
    name: 'payment',
  },
  {
    id: 2,
    code: 2,
    name: 'acceptance',
  },
  {
    id: 3,
    code: 3,
    name: 'paper',
  }
]

const statuses = [
  {
    id: 1,
    code: 1,
    text: 'Unavailable',
    color: 'secondary',

    // belongsTo relations
    type_id: 1,

    // belongsTo relation objects
    type: stypes[0],
  },
  {
    id: 2,
    code: 2,
    text: 'Unpaid',
    color: 'warning',

    // belongsTo relations
    type_id: 1,

    // belongsTo relation objects
    type: stypes[0],
  },
  {
    id: 3,
    code: 3,
    text: 'Paid',
    color: 'success',

    // belongsTo relations
    type_id: 1,

    // belongsTo relation objects
    type: stypes[0],
  },
  {
    id: 4,
    code: 4,
    text: 'Unsigned',
    color: 'secondary',

    // belongsTo relations
    type_id: 2,

    // belongsTo relation objects
    type: stypes[1],
  },
  {
    id: 5,
    code: 5,
    text: 'Reviewing',
    color: 'info',

    // belongsTo relations
    type_id: 2,

    // belongsTo relation objects
    type: stypes[1],
  },
  {
    id: 6,
    code: 6,
    text: 'Accepted',
    color: 'success',

    // belongsTo relations
    type_id: 2,

    // belongsTo relation objects
    type: stypes[1],
  },
  {
    id: 7,
    code: 7,
    text: 'Rejected',
    color: 'danger',

    // belongsTo relations
    type_id: 2,

    // belongsTo relation objects
    type: stypes[1],
  },
  {
    id: 8,
    code: 8,
    text: 'Comfirmed',
    color: 'success',

    // belongsTo relations
    type_id: 3,

    // belongsTo relation objects
    type: stypes[2],
  },
  {
    id: 9,
    code: 9,
    text: 'Rejected',
    color: 'danger',

    // belongsTo relations
    type_id: 3,

    // belongsTo relation objects
    type: stypes[2],
  },
  {
    id: 10,
    code: 10,
    text: 'Waiting',
    color: 'info',

    // belongsTo relations
    type_id: 3,

    // belongsTo relation objects
    type: stypes[2],
  }
]

// Array topics
const topics = [
  {
    id: 1,
    name: 'Topic1'
  },
  {
    id: 2,
    name: 'Topic2'
  },
  {
    id: 3,
    name: 'Topic3'
  },
  {
    id: 4,
    name: 'Topic4'
  },
  // Add new topic here
  {
    id: 5,
    name: 'Topic5'
  }
]

// Array roles
const roles = [
  {
    id: 1,
    code: 1,
    name: 'Admin'
  },
  {
    id: 2,
    code: 2,
    name: 'Reviewer'
  },
  {
    id: 3,
    code: 3,
    name: 'Presenter'
  },
  {
    id: 4,
    code: 4,
    name: 'Participant'
  }
]

// Array users
const users = [
  {
    // Originals
    id: 1,
    img: '/assets/img/person-circle.svg',
    name: 'Presenter Name',
    email: 'presenter@mail.com',
    isActive: 1,
    // .etc

    // belongsTo relations
    role_id: 3,

    // belongsTo relation objects
    role: roles[2],
  },
  {
    // Originals
    id: 2,
    img: '/assets/img/person-circle.svg',
    name: 'Prof. Dr. Lecturer Name, M. Kom',
    email: 'reviewer@mail.com',
    isActive: 0,
    // .etc

    // belongsTo relations
    role_id: 2,

    // belongsTo relation objects
    role: roles[1],
  },
  // Add new user here
  {
    id: 3,
    img: '/assets/img/person-circle.svg',
    name: 'Coordinator Name',
    email: 'coordinator@mail.com',
    isActive: 1,
    // .etc

    // belongsTo relations
    role_id: 1,

    // belongsTo relation objects
    role: roles[0],
  }
]

// Array reviews
const reviews = [
  {
    // Originals
    id: 1,
    file: 'file.jpg',
    comment: 'Lorem ipsum dolor sit amet dictumst velit purus placerat proin feugiat consequat eget sem vivamus ligula morbi gravida odio libero laoreet luctus sit faucibus dolor adipiscing at ante parturient praesent',
    file: 'file.jpg',

    // belongsTo relations
    abstract_id: 1,
    status_id: statuses[4].id,

    // belongsTo relation objects
    status: statuses[4],
  },
  {
    id: 2,
    file: 'file2.jpg',
    comment: 'Another review comment...',
    file: 'file2.jpg',

    // belongsTo relations
    abstract_id: 2,
    status_id: statuses[5].id,

    // belongsTo relation objects
    status: statuses[5],
  }
]

// Array troles
const troles = [
  {
    id: 1,
    name: 'Presenter'
  },
  {
    id: 2,
    name: 'Listener'
  }
]

// Array ttypes
const ttypes = [
  {
    id: 1,
    name: 'Early Bird'
  },
  {
    id: 2,
    name: 'Regular'
  }
]

// Array states
const states = [
  {
    id: 1,
    name: 'Local'
  },
  {
    id: 2,
    name: 'International'
  },
  // Add new state here
  {
    id: 3,
    name: 'National'
  }
]

// Array studies
const studies = [
  {
    id: 1,
    name: 'Not a Student'
  },
  {
    id: 2,
    name: 'Undergraduate Student'
  },
  {
    id: 3,
    name: 'Master and Doctoral Student'
  },
  // Add new graduation here
  {
    id: 4,
    name: 'Postgraduate Student'
  }
]

// Array tickets
const tickets = [
  {
    // Originals
    id: 1,
    name: 'Ticket1',
    attendance: 'online',
    price: 400000,

    // belongsTo relations
    type_id: 1,
    role_id: 3,
    state_id: 1,
    study_id: 1,

    // belongsTo relation objects
    type: ttypes[0],
    role: troles[0],
    state: states[0],
    study: studies[0],
  },
  {
    id: 2,
    name: 'Ticket2',
    attendance: 'offline',
    price: 800000,

    // belongsTo relations
    type_id: 2,
    role_id: 5,
    state_id: 2,
    study_id: 4,

    // belongsTo relation objects
    type: ttypes[1],
    role: troles[1],
    state: states[1],
    study: studies[3],
  }
]

// Array ticket_user (many-to-many)
const ticket_user = [
  {
    // Originals
    id: 1,
    file: 'file.jpg',
    student_card: 'student.jpg',
    status: statuses[1],

    // belongsTo relations
    abstract_id: 1,
    user_id: 1,
    ticket_id: 1,

    // belongsTo relation objects
    user: users[0],
    ticket: tickets[0],

    created_at: '2021-08-01 00:00:00',
  },
  {
    id: 2,
    file: 'file2.jpg',
    student_card: 'student2.jpg',
    status: statuses[2],

    // belongsTo relations
    abstract_id: 2,
    user_id: 3,
    ticket_id: 2,

    // belongsTo relation objects
    user: users[2],
    ticket: tickets[1],

    created_at: '2021-08-01 00:00:00',
  }
]

// Array abstracts
const abstracts = [
  {
    // Originals
    id: 1, //uuid
    title: `Title1`,
    authors: 'Writer1, Writer2, Writer3',
    emails: 'writer1@gmail.com, writer2@gmail.com, writer3@gmail.com',
    text: 'Lorem ipsum dolor sit amet dictumst velit purus placerat proin feugiat consequat eget sem vivamus ligula morbi gravida odio libero laoreet luctus sit faucibus dolor adipiscing at ante parturient praesent',

    // belongsTo relations
    creator_id: users[0].id,
    topic_id: topics[0].id,
    reviewer_id: users[1].id,

    // belongsTo relation objects
    creator: users[0],
    topic: topics[0],
    reviewer: users[1],

    // hasOne relations
    reviews: [reviews[0]],
    ticket_user: ticket_user[0],
  },
  // Add new abstract entry here
  {
    id: 2, //uuid
    title: `Another Title`,
    authors: 'Another Writer1, Another Writer2',
    emails: 'anotherwriter1@gmail.com, anotherwriter2@gmail.com',
    text: 'Another lorem ipsum dolor sit amet...',

    // belongsTo relations
    creator_id: users[1].id,
    topic_id: topics[1].id,
    reviewer_id: null,

    // belongsTo relation objects
    creator: users[1],
    topic: topics[1],
    reviewer: null,

    // hasMany relations
    reviews: [],

    // hasOne relations
    ticket_user: null,
  }
]

const publications = [
  {
    id: 1,
    name: 'Publication1'
  },
  {
    id: 2,
    name: 'Publication2'
  },
  {
    id: 3,
    name: 'Publication3'
  },
  {
    id: 4,
    name: 'Publication4'
  },
]

const papers = [
  {
    // Originals
    id: 1,
    file: 'file.pdf',
    provement: 'file2.pdf',
    status: statuses[8],

    // belongsTo relations
    abstract_id: 1,
    publication_id: 1,

    // belongsTo relation objects
    abstract: abstracts[0],
    publication: publications[0],
  }
]
