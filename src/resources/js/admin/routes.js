import Home from './views/Home';
import PageNotFound from '../views/PageNotFound';
import ProductionsList from './views/productions/List';
import ProductionDetails from './views/productions/Details';
import ProductionEdit from './views/productions/Edit';
import ProductionCreate from './views/productions/Create';
import EventDetails from './views/events/Details';
import EventEdit from './views/events/Edit';
import ProfileSettings from './views/profile/Settings';
import ApiTokens from './views/profile/ApiTokens';
import InviteUser from './views/profile/Invite';
import OrganizationsList from './views/organizations/List';
import OrganizationDetails from './views/organizations/Details';
import OrganizationEdit from './views/organizations/Edit';
import OrganizationPeopleDetails from './views/organizations/people/Details';
import GigadEdit from './views/organizations/gigs/Edit';

export function getRoutes() {
    return [
        {
            path: '/',
            name: 'home',
            component: Home
        },
        {
            path: '/productions',
            name: 'productions',
            component: ProductionsList,
        },
        {
            path: '/events/:uid',
            name: 'event.details',
            component: EventDetails,
        },
        {
            path: '/events/:uid/edit',
            name: 'event.edit',
            component: EventEdit,
        },
        {
            path: '/productions/create',
            name: 'production.create',
            component: ProductionCreate,
        },
        {
            path: '/productions/:uid',
            name: 'production.details',
            component: ProductionDetails,
        }, {
            path: '/productions/:uid/edit',
            name: 'production.edit',
            component: ProductionEdit,
        },

        {
            path: '/profile/settings',
            name: 'profile.settings',
            component: ProfileSettings,
        },
        {
            path: '/profile/tokens',
            name: 'profile.api.tokens',
            component: ApiTokens,
        },
        {
            path: '/profile/invite',
            name: 'profile.invite',
            component: InviteUser,
        },
        {
            path: '/organizations',
            name: 'organizations',
            component: OrganizationsList,
        },
        {
            path: '/organizations/:uid',
            name: 'organization.details',
            component: OrganizationDetails,
        },
        {
            path: '/organizations/:uid/edit',
            name: 'organization.edit',
            component: OrganizationEdit,
        },
        {
            path: '/organizations/:uid/people/:username',
            name: 'organizations.people.details',
            component: OrganizationPeopleDetails
        },
        {
            path: '/gigads/:uid/edit',
            name: 'gigads.edit',
            component: GigadEdit,
        },
        {path: '*', component: PageNotFound}
    ];
}
