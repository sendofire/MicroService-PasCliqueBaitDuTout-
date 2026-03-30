package fr.univamu.iut.microservicepascliquebaitdutout;

import jakarta.inject.Inject;
import jakarta.ws.rs.client.Client;
import jakarta.ws.rs.client.ClientBuilder;
import jakarta.ws.rs.core.MediaType;
import jakarta.ws.rs.core.Response;
import jakarta.enterprise.context.ApplicationScoped;

import java.util.List;

@ApplicationScoped
public class MenuService {

    @Inject
    private MenuDAO dao;

    private static final String PLATS_API = "http://localhost:3003";


    public List<Menu> findAll() {
        return dao.findAll();
    }

    public Menu findById(int id) {
        return dao.findById(id);
    }

    public Menu create(Menu m) {
        return dao.create(m);
    }

    public Menu update(Menu m) {
        return dao.update(m);
    }

    public void delete(int id) {
        dao.delete(id);
    }


    public boolean platExists(int platId) {
        try (Client client = ClientBuilder.newClient()) {
            Response r = client.target(PLATS_API)
                    .path("/plats/{id}")
                    .resolveTemplate("id", platId)
                    .request(MediaType.APPLICATION_JSON)
                    .get();
            return r.getStatus() == 200;
        }
    }

    public Menu addPlatToMenu(int menuId, int platId) {
        if (!platExists(platId)) {
            throw new IllegalArgumentException("Plat " + platId + " not found");
        }
        Menu m = dao.findById(menuId);
        m.getPlatIds().add(platId);
        return dao.update(m);
    }

    public Menu removePlatFromMenu(int menuId, int platId) {
        Menu m = dao.findById(menuId);
        m.getPlatIds().remove(Integer.valueOf(platId));
        return dao.update(m);
    }
}