import { Selector } from 'testcafe';
import { Role } from 'testcafe';

fixture `Navigation`
  .page `http://localhost:8000/home`;

const userLogged = Role('http://localhost:8000/login', async t => {
await t
    .typeText('#email', 'user@user.com')
    .typeText('#password', 'user')
    .click('.btn-primary');
});

test('navigation', async t => {
    await t
        .useRole(userLogged)
        .wait(2000)
        .expect(Selector('.titleProfile').innerText).eql('DÉCOUVRIR LES PLATS')
        .click('#map-link')
        .expect(Selector('.leaflet-container').exists).ok()
        .wait(2000)
        .click('#top-10')
        .wait(2000)
        .click('#demandes')
        .wait(2000)
        .click('#community')
        .wait(2000)
        .click('#news')
        .wait(2000)
        .click('#navbarDropdown')
        .wait(2000);

});
